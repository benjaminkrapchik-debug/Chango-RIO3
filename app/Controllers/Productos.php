<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use CodeIgniter\Controller;

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

  

    private function mostrarProductos($nombreSupermercado)
    {
        $db = \Config\Database::connect();

        $buscar = trim((string) $this->request->getGet('buscar'));

        $consulta = $db->table('productos p')
        ->select('p.*, s.nombre AS supermercado')
            ->join(
                'supermercados s',
                's.id = p.supermercado_id',
                'inner'
            );

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
                $item['precio'] * $item['cantidad'];
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


    public function eliminar($id)
    {
        $modelo = new ProductosModel();

        $producto = $modelo->find($id);

        if (!$producto) {
            return redirect()->back()
                ->with('error', 'Producto no encontrado.');
        }

        $modelo->delete($id);

        return redirect()->back()
            ->with('mensaje', 'Producto eliminado correctamente.');
    }


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

        if ($cantidad > $producto['stock']) {
            return redirect()->back()
                ->with('error', 'No hay stock suficiente.');
        }

        $carrito = session()->get('carrito') ?? [];

        $cantidadActual = isset($carrito[$id])
            ? $carrito[$id]['cantidad']
            : 0;

        if (($cantidadActual + $cantidad) > $producto['stock']) {
            return redirect()->back()
                ->with('error', 'No hay stock suficiente para esa cantidad.');
        }

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $cantidad;
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

   

    public function eliminarCarrito($id)
    {
        $carrito = session()->get('carrito') ?? [];

        unset($carrito[$id]);

        session()->set('carrito', $carrito);

        return redirect()->back()
            ->with('mensaje', 'Producto eliminado del carrito.');
    }


    public function vaciarCarrito()
    {
        session()->remove('carrito');

        return redirect()->back()
            ->with('mensaje', 'Carrito vaciado correctamente.');
    }

   
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

        $total = 0;
        $detalles = [];

        foreach ($carrito as $item) {

            $producto = $db->table('productos')
                ->where('id', $item['id'])
                ->get()
                ->getRowArray();

            if (
                !$producto ||
                $item['cantidad'] > $producto['stock']
            ) {
                $db->transRollback();

                return redirect()->to(site_url('productos'))
                    ->with('error', 'No hay stock suficiente para ' . $item['nombre']);
            }

            $precio = (float) $producto['precio'];
            $cantidad = (int) $item['cantidad'];

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

        $db->table('compras')->insert([
            'usuario_id' => $usuarioId,
            'total' => $total
        ]);

        $compraId = $db->insertID();

        foreach ($detalles as $detalle) {

            $detalle['compra_id'] = $compraId;

            $db->table('detalle_compras')->insert($detalle);

            $db->table('productos')
                ->where('id', $detalle['producto_id'])
                ->set(
                    'stock',
                    'stock - ' . (int) $detalle['cantidad'],
                    false
                )
                ->update();
        }

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->to(site_url('productos'))
                ->with('error', 'No se pudo guardar la compra.');
        }

        $db->transCommit();

        session()->remove('carrito');

        return redirect()->to(site_url('historial'))
            ->with('mensaje', '¡Compra registrada correctamente!');
    }
}
