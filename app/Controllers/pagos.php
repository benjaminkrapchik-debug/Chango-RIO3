<?php

namespace App\Controllers;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;

class Pagos extends BaseController
{
    private function configurarMercadoPago()
    {
        $token = env('MERCADOPAGO_ACCESS_TOKEN');

        if (empty($token)) {
            throw new \RuntimeException(
                'Falta configurar MERCADOPAGO_ACCESS_TOKEN en .env'
            );
        }

        MercadoPagoConfig::setAccessToken($token);
    }

    // CREAR EL PAGO A PARTIR DE UNA COMPRA PENDIENTE
    public function crear($compraId)
    {
        if (!session()->get('logueado')) {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();

        $compra = $db->table('compras')
            ->where('id', $compraId)
            ->where('usuario_id', session()->get('usuario_id'))
            ->get()
            ->getRowArray();

        if (!$compra || $compra['estado'] !== 'pendiente') {
            return redirect()->to(site_url('productos'))
                ->with('error', 'La compra no existe o ya fue procesada.');
        }

        $detalles = $db->table('detalle_compras')
            ->where('compra_id', $compraId)
            ->get()
            ->getResultArray();

        if (empty($detalles)) {
            return redirect()->to(site_url('productos'))
                ->with('error', 'La compra no tiene productos.');
        }

        $items = [];

        foreach ($detalles as $detalle) {
            $items[] = [
                'title' => $detalle['nombre_producto'],
                'quantity' => (int) $detalle['cantidad'],
                'unit_price' => (float) $detalle['precio'],
                'currency_id' => 'ARS'
            ];
        }

        try {
            $this->configurarMercadoPago();

            $cliente = new PreferenceClient();

            $base = rtrim(base_url(), '/');

            $notificacion = env('MP_NOTIFICATION_URL');

            $preferencia = $cliente->create([
                'items' => $items,

                'external_reference' => (string) $compraId,

                'back_urls' => [
                    'success' => $base . '/pagos/aprobado',
                    'failure' => $base . '/pagos/rechazado',
                    'pending' => $base . '/pagos/pendiente'
                ],

                'auto_return' => 'approved',

                'notification_url' => $notificacion,

                'payer' => [
                    'email' => session()->get('usuario_email')
                        ?: 'test_user_123456@testuser.com'
                ]
            ]);

            $db->table('pagos')
                ->where('compra_id', $compraId)
                ->update([
                    'preference_id' => $preferencia->id
                ]);

            return redirect()->to($preferencia->init_point);

        } catch (\Throwable $e) {
            log_message('error', 'Mercado Pago: ' . $e->getMessage());

            return redirect()->to(site_url('productos'))
                ->with('error', 'No se pudo iniciar el pago. Revisá la configuración de Mercado Pago.');
        }
    }

    // ACTUALIZAR EL ESTADO CONSULTANDO A MERCADO PAGO
    private function actualizarPago($paymentId)
    {
        $this->configurarMercadoPago();

        $cliente = new PaymentClient();

        $pagoMP = $cliente->get($paymentId);

        $compraId = $pagoMP->external_reference ?? null;
        $estadoMP = $pagoMP->status ?? null;
        $montoMP = (float) ($pagoMP->transaction_amount ?? 0);

        if (!$compraId || !$estadoMP) {
            throw new \RuntimeException('El pago no tiene una referencia válida.');
        }

        $db = \Config\Database::connect();

        $compra = $db->table('compras')
            ->where('id', $compraId)
            ->get()
            ->getRowArray();

        if (!$compra || abs((float) $compra['total'] - $montoMP) > 0.01) {
            throw new \RuntimeException('La compra o el importe no coinciden.');
        }

        $pago = $db->table('pagos')
            ->where('compra_id', $compraId)
            ->get()
            ->getRowArray();

        if (!$pago) {
            throw new \RuntimeException('No se encontró el registro del pago.');
        }

        // No volver a procesar una compra ya aprobada.
        if ($compra['estado'] === 'aprobada') {
            return 'approved';
        }

        $db->transBegin();

        $db->table('pagos')
            ->where('compra_id', $compraId)
            ->update([
                'payment_id' => (string) $paymentId,
                'estado' => $estadoMP
            ]);

        if ($estadoMP === 'approved') {

            $detalles = $db->table('detalle_compras')
                ->where('compra_id', $compraId)
                ->get()
                ->getResultArray();

            foreach ($detalles as $detalle) {

                // Descuento condicionado al stock disponible.
                $db->table('productos')
                    ->where('id', $detalle['producto_id'])
                    ->where('stock >=', $detalle['cantidad'])
                    ->set(
                        'stock',
                        'stock - ' . (int) $detalle['cantidad'],
                        false
                    )
                    ->update();

                if ($db->affectedRows() !== 1) {
                    $db->transRollback();

                    throw new \RuntimeException(
                        'No hay stock suficiente para completar la compra.'
                    );
                }
            }

            $db->table('compras')
                ->where('id', $compraId)
                ->update(['estado' => 'aprobada']);

        } elseif ($estadoMP === 'rejected') {

            $db->table('compras')
                ->where('id', $compraId)
                ->update(['estado' => 'rechazada']);

        } else {

            $db->table('compras')
                ->where('id', $compraId)
                ->update(['estado' => 'pendiente']);
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            throw new \RuntimeException('No se pudo actualizar el pago.');
        }

        $db->transCommit();

        return $estadoMP;
    }

    // RETORNOS DE MERCADO PAGO
    public function aprobado()
    {
        return $this->procesarRetorno('approved');
    }

    public function rechazado()
    {
        return $this->procesarRetorno('rejected');
    }

    public function pendiente()
    {
        return $this->procesarRetorno('pending');
    }

    private function procesarRetorno($resultadoEsperado)
    {
        $paymentId = $this->request->getGet('payment_id');

        if (!$paymentId) {
            return redirect()->to(site_url('productos'))
                ->with('error', 'No se recibió el identificador del pago.');
        }

        try {
            $estadoReal = $this->actualizarPago($paymentId);

            if ($estadoReal === 'approved') {
                return view('pagos/resultado', [
                    'titulo' => '¡Pago aprobado!',
                    'mensaje' => 'Tu compra fue pagada correctamente.',
                    'estado' => 'aprobado'
                ]);
            }

            if ($estadoReal === 'rejected') {
                return view('pagos/resultado', [
                    'titulo' => 'Pago rechazado',
                    'mensaje' => 'El pago fue rechazado. Podés intentar nuevamente.',
                    'estado' => 'rechazado'
                ]);
            }

            return view('pagos/resultado', [
                'titulo' => 'Pago pendiente',
                'mensaje' => 'Estamos esperando la confirmación del pago.',
                'estado' => 'pendiente'
            ]);

        } catch (\Throwable $e) {
            log_message('error', 'Retorno Mercado Pago: ' . $e->getMessage());

            return redirect()->to(site_url('productos'))
                ->with('error', 'No pudimos verificar el pago. Consultá tu historial.');
        }
    }

    // NOTIFICACIÓN AUTOMÁTICA DE MERCADO PAGO
    public function notificacion()
    {
        $datos = $this->request->getJSON(true);

        $paymentId = $datos['data']['id']
            ?? $this->request->getGet('data.id')
            ?? $this->request->getGet('id');

        if (!$paymentId) {
            return $this->response->setStatusCode(400);
        }

        try {
            $this->actualizarPago($paymentId);

            return $this->response->setStatusCode(200);

        } catch (\Throwable $e) {
            log_message('error', 'Webhook Mercado Pago: ' . $e->getMessage());

            return $this->response->setStatusCode(500);
        }
    }
}