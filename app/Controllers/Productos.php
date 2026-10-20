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
}