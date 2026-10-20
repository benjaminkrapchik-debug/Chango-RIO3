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
}