<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Producto extends BaseController
{
    public function index()
    {
        $modelo = new ProductoModel();

        $buscar = trim((string) $this->request->getGet('buscar'));
        $orden = (string) $this->request->getGet('orden');

        $consulta = $modelo;

        if ($buscar !== '') {
            $consulta = $consulta
                ->groupStart()
                ->like('nombre', $buscar)
                ->orLike('descripcion', $buscar)
                ->groupEnd();
        }

        switch ($orden) {
            case 'precio_asc':
                $consulta->orderBy('precio', 'ASC');
                break;

            case 'precio_desc':
                $consulta->orderBy('precio', 'DESC');
                break;

            default:
                $consulta->orderBy('nombre', 'ASC');
                break;
        }

        $datos = [
            'productos' => $consulta->findAll(),
            'buscar' => $buscar,
            'orden' => $orden,
        ];

        return view('productos/index', $datos);
    }
}