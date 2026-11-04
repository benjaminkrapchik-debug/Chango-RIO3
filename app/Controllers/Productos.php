<?php

namespace App\Controllers;

use App\Models\ProductosModel;

class Productos extends BaseController
{
    
    public function index()
    {
        $modelo = new ProductosModel();

        $buscar = trim((string) $this->request->getGet('buscar'));

        if ($buscar !== '') {
            $modelo->like('nombre', $buscar);
        }

        $productos = $modelo->orderBy('id', 'DESC')->findAll();
        $carrito = session()->get('carrito') ?? [];
$totalCarrito = 0;

foreach ($carrito as $item) {
    $totalCarrito += $item['precio'] * $item['cantidad'];
}

return view('productos/index', [
    'productos' => $productos,
    'buscar' => $buscar,
    'carrito' => $carrito,
    'totalCarrito' => $totalCarrito
]);
    }

   
    public function guardar()
    {
        $modelo = new ProductosModel();

        $datos = [
            'nombre' => $this->request->getPost('nombre'),
            'precio' => $this->request->getPost('precio'),
            'stock'  => $this->request->getPost('stock')
        ];

        if (
            empty($datos['nombre']) ||
            !is_numeric($datos['precio']) ||
            $datos['precio'] <= 0 ||
            !is_numeric($datos['stock']) ||
            $datos['stock'] < 0
        ) {
            return redirect()->to(base_url('productos'))
                ->with('error', 'Completá correctamente los datos.');
        }

        $modelo->insert($datos);

        return redirect()->to(base_url('productos'))
            ->with('mensaje', 'Producto agregado correctamente.');
    }

    
    public function eliminar($id)
    {
        $modelo = new ProductosModel();

        if (!$modelo->find($id)) {
            return redirect()->to(base_url('productos'))
                ->with('error', 'Producto no encontrado.');
        }

        $modelo->delete($id);

        return redirect()->to(base_url('productos'))
            ->with('mensaje', 'Producto eliminado correctamente.');
    }
   
public function agregarCarrito($id)
{
    $modelo = new \App\Models\ProductosModel();

    $producto = $modelo->find($id);

    if (!$producto) {
        return redirect()->to(base_url('productos'))
            ->with('error', 'El producto no existe.');
    }

    $cantidad = max(1, (int) $this->request->getPost('cantidad'));

    $carrito = session()->get('carrito') ?? [];

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

    return redirect()->to(base_url('productos'))
        ->with('mensaje', 'Producto agregado al carrito.');
}



public function eliminarCarrito($id)
{
    $carrito = session()->get('carrito') ?? [];

    unset($carrito[$id]);

    session()->set('carrito', $carrito);

    return redirect()->to(base_url('productos'));
}



public function vaciarCarrito()
{
    session()->remove('carrito');

    return redirect()->to(base_url('productos'));
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

        if (!$producto || $item['cantidad'] > $producto['stock']) {
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
            ->set('stock', 'stock - ' . $detalle['cantidad'], false)
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
