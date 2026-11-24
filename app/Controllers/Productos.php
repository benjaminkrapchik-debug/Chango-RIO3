<?php

namespace App\Controllers;

use App\Models\ProductosModel;

class Productos extends BaseController
{
    public function index()
    {
        return $this->mostrarProductos(null);
    }

    public function vea()
    {
        return $this->mostrarProductos('Vea');
    }

    public function luconi()
    {
        return $this->mostrarProductos('Luconi');
    }

    public function caracol()
    {
        return $this->mostrarProductos('Caracol');
    }

    // MOSTRAR PRODUCTOS
    private function mostrarProductos($nombreSupermercado)
    {
        $db = \Config\Database::connect();

        $buscar = trim((string) $this->request->getGet('buscar'));

        $consulta = $db->table('productos p')
            ->select('p.*, s.nombre AS supermercado')
            ->join('supermercados s', 's.id = p.supermercado_id', 'inner');

        if ($nombreSupermercado !== null) {
            $consulta->where('s.nombre', $nombreSupermercado);
        }

        if ($buscar !== '') {
            $consulta->like('p.nombre', $buscar);
        }

        $productos = $consulta
            ->orderBy('p.id', 'DESC')
            ->get()
            ->getResultArray();

        $supermercados = $db->table('supermercados')
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResultArray();

        $carrito = session()->get('carrito') ?? [];

        $totalCarrito = 0;

        foreach ($carrito as $item) {
            $totalCarrito +=
                (float) $item['precio'] * (int) $item['cantidad'];
        }

        return view('productos/index', [
            'productos' => $productos,
            'buscar' => $buscar,
            'carrito' => $carrito,
            'totalCarrito' => $totalCarrito,
            'supermercados' => $supermercados,
            'supermercadoActual' => $nombreSupermercado
        ]);
    }

    // AGREGAR PRODUCTO
    public function guardar()
    {
        $modelo = new ProductosModel();

        $nombre = trim((string) $this->request->getPost('nombre'));
        $precio = $this->request->getPost('precio');
        $stock = $this->request->getPost('stock');
        $supermercadoId = $this->request->getPost('supermercado_id');

        if (
            $nombre === '' ||
            !is_numeric($precio) ||
            $precio <= 0 ||
            !is_numeric($stock) ||
            $stock < 0 ||
            !ctype_digit((string) $supermercadoId)
        ) {
            return redirect()->back()
                ->with('error', 'Completá correctamente todos los datos.');
        }

        $db = \Config\Database::connect();

        $supermercado = $db->table('supermercados')
            ->where('id', $supermercadoId)
            ->get()
            ->getRowArray();

        if (!$supermercado) {
            return redirect()->back()
                ->with('error', 'El supermercado seleccionado no existe.');
        }

        $datos = [
            'nombre' => $nombre,
            'precio' => $precio,
            'stock' => $stock,
            'supermercado_id' => $supermercadoId
        ];

        if (!$modelo->insert($datos)) {
            return redirect()->back()
                ->with('error', 'No se pudo guardar el producto.');
        }

        return redirect()->to(site_url('productos'))
            ->with('mensaje', 'Producto agregado correctamente.');
    }

    // MOSTRAR FORMULARIO PARA EDITAR
    public function editar($id)
    {
        $modelo = new ProductosModel();

        $producto = $modelo->find($id);

        if (!$producto) {
            return redirect()->to(site_url('productos'))
                ->with('error', 'Producto no encontrado.');
        }

        $db = \Config\Database::connect();

        $supermercados = $db->table('supermercados')
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResultArray();

        return view('productos/editar', [
            'producto' => $producto,
            'supermercados' => $supermercados
        ]);
    }

    // ACTUALIZAR PRODUCTO
    public function actualizar($id)
    {
        $modelo = new ProductosModel();

        $producto = $modelo->find($id);

        if (!$producto) {
            return redirect()->to(site_url('productos'))
                ->with('error', 'Producto no encontrado.');
        }

        $nombre = trim((string) $this->request->getPost('nombre'));
        $precio = $this->request->getPost('precio');
        $stock = $this->request->getPost('stock');
        $supermercadoId = $this->request->getPost('supermercado_id');

        if (
            $nombre === '' ||
            !is_numeric($precio) ||
            $precio <= 0 ||
            !is_numeric($stock) ||
            $stock < 0 ||
            !ctype_digit((string) $supermercadoId)
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Completá correctamente todos los datos.');
        }

        $db = \Config\Database::connect();

        $supermercado = $db->table('supermercados')
            ->where('id', $supermercadoId)
            ->get()
            ->getRowArray();

        if (!$supermercado) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'El supermercado seleccionado no existe.');
        }

        $datos = [
            'nombre' => $nombre,
            'precio' => $precio,
            'stock' => $stock,
            'supermercado_id' => $supermercadoId
        ];

        if (!$modelo->update($id, $datos)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No se pudieron actualizar los datos.');
        }

        // ACTUALIZAR PRODUCTO EN EL CARRITO
        $carrito = session()->get('carrito') ?? [];

        if (isset($carrito[$id])) {
            $carrito[$id]['nombre'] = $nombre;
            $carrito[$id]['precio'] = $precio;

            if ((int) $carrito[$id]['cantidad'] > (int) $stock) {
                unset($carrito[$id]);
            }

            session()->set('carrito', $carrito);
        }

        return redirect()->to(site_url('productos'))
            ->with('mensaje', 'Producto actualizado correctamente.');
    }

    // ELIMINAR PRODUCTO
    public function eliminar($id)
    {
        $modelo = new ProductosModel();

        $producto = $modelo->find($id);

        if (!$producto) {
            return redirect()->back()
                ->with('error', 'Producto no encontrado.');
        }

        $modelo->delete($id);

        $carrito = session()->get('carrito') ?? [];

        unset($carrito[$id]);

        session()->set('carrito', $carrito);

        return redirect()->back()
            ->with('mensaje', 'Producto eliminado correctamente.');
    }

    // AGREGAR AL CARRITO
    public function agregarCarrito($id)
    {
        $modelo = new ProductosModel();

        $producto = $modelo->find($id);

        if (!$producto) {
            return redirect()->back()
                ->with('error', 'El producto no existe.');
        }

        $cantidad = (int) $this->request->getPost('cantidad');

        if ($cantidad < 1) {
            return redirect()->back()
                ->with('error', 'La cantidad debe ser mayor a cero.');
        }

        if ($cantidad > (int) $producto['stock']) {
            return redirect()->back()
                ->with('error', 'No hay stock suficiente.');
        }

        $carrito = session()->get('carrito') ?? [];

        $cantidadActual = isset($carrito[$id])
            ? (int) $carrito[$id]['cantidad']
            : 0;

        if (($cantidadActual + $cantidad) > (int) $producto['stock']) {
            return redirect()->back()
                ->with('error', 'No hay stock suficiente para esa cantidad.');
        }

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
            $carrito[$id]['precio'] = $producto['precio'];
            $carrito[$id]['nombre'] = $producto['nombre'];
        } else {
            $carrito[$id] = [
                'id' => $producto['id'],
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $cantidad
            ];
        }

        session()->set('carrito', $carrito);

        return redirect()->back()
            ->with('mensaje', 'Producto agregado al carrito.');
    }

    // ELIMINAR DEL CARRITO
    public function eliminarCarrito($id)
    {
        $carrito = session()->get('carrito') ?? [];

        unset($carrito[$id]);

        session()->set('carrito', $carrito);

        return redirect()->back()
            ->with('mensaje', 'Producto eliminado del carrito.');
    }

    // VACIAR CARRITO
    public function vaciarCarrito()
    {
        session()->remove('carrito');

        return redirect()->back()
            ->with('mensaje', 'Carrito vaciado correctamente.');
    }

    // FINALIZAR COMPRA Y CREAR PEDIDO PENDIENTE
    public function finalizarCompra()
    {
        if (!session()->get('logueado')) {
            return redirect()->to(site_url('login'));
        }

        $usuarioId = session()->get('usuario_id');
        $carrito = session()->get('carrito') ?? [];

        if (empty($carrito)) {
            return redirect()->to(site_url('productos'))
                ->with('error', 'El carrito está vacío.');
        }

        $db = \Config\Database::connect();

        $db->transBegin();

        try {
            $total = 0;
            $detalles = [];

            // CONSULTAR PRODUCTOS Y PRECIOS REALES
            foreach ($carrito as $item) {

                $producto = $db->table('productos')
                    ->where('id', $item['id'])
                    ->get()
                    ->getRowArray();

                if (!$producto) {
                    throw new \RuntimeException(
                        'Uno de los productos ya no existe.'
                    );
                }

                $cantidad = (int) $item['cantidad'];

                if (
                    $cantidad < 1 ||
                    $cantidad > (int) $producto['stock']
                ) {
                    throw new \RuntimeException(
                        'No hay stock suficiente para ' . $producto['nombre']
                    );
                }

                $precio = (float) $producto['precio'];
                $subtotal = $precio * $cantidad;

                $total += $subtotal;

                $detalles[] = [
                    'producto_id' => $producto['id'],
                    'nombre_producto' => $producto['nombre'],
                    'precio' => $precio,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ];
            }

            // CREAR COMPRA PENDIENTE
            $db->table('compras')->insert([
                'usuario_id' => $usuarioId,
                'total' => $total,
                'estado' => 'pendiente'
            ]);

            $compraId = $db->insertID();

            if (!$compraId) {
                throw new \RuntimeException(
                    'No se pudo crear el pedido.'
                );
            }

            // GUARDAR DETALLES DE LA COMPRA
            foreach ($detalles as $detalle) {
                $detalle['compra_id'] = $compraId;

                $db->table('detalle_compras')->insert($detalle);
            }

            // CREAR REGISTRO DEL PAGO
            $db->table('pagos')->insert([
                'compra_id' => $compraId,
                'usuario_id' => $usuarioId,
                'monto' => $total,
                'estado' => 'pending'
            ]);

            if ($db->transStatus() === false) {
                throw new \RuntimeException(
                    'No se pudo guardar el pedido y sus detalles.'
                );
            }

            $db->transCommit();

            // REDIRIGIR AL CHECKOUT DE MERCADO PAGO
            return redirect()->to(
                site_url('pagos/crear/' . $compraId)
            );

        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Error al crear compra: ' . $e->getMessage()
            );

            return redirect()->to(site_url('productos'))
                ->with('error', $e->getMessage());
        }
    }
}
