<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Productos extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();

        $datos['productos'] = $productoModel->findAll();

        return view('producto/index', $datos);
    }
    protected $table = 'productos';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'stock'
    ];

    protected $useTimestamps = false;
    
public function nuevo()
{
    if (!session()->get('logueado')) {
        return redirect()->to(site_url('login'));
    }

    return view('productos/nuevo');
}

public function guardar()
{
    if (!session()->get('logueado')) {
        return redirect()->to(site_url('login'));
    }

    $reglas = [
        'nombre' => 'required|min_length[2]|max_length[150]',
        'descripcion' => 'permit_empty|max_length[500]',
        'precio' => 'required|decimal|greater_than_equal_to[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]'
    ];

    if (!$this->validate($reglas)) {
        return redirect()->back()
            ->withInput()
            ->with('errores', $this->validator->getErrors());
    }

    $modelo = new \App\Models\ProductoModel();

    $modelo->insert([
        'nombre' => trim($this->request->getPost('nombre')),
        'descripcion' => trim(
            (string) $this->request->getPost('descripcion')
        ),
        'precio' => $this->request->getPost('precio'),
        'stock' => $this->request->getPost('stock')
    ]);

    return redirect()->to(site_url('productos'))
        ->with('mensaje', 'Producto agregado correctamente.');
}

}