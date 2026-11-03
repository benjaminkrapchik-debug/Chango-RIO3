<?php

namespace App\Controllers;

use App\Models\ProductosModel;

class Productos extends BaseController
{
    public function index()
    {
        $modelo = new ProductosModel();

        $buscar = trim((string) $this->request->getGet('buscar'));

        $consulta = $modelo;

        if ($buscar !== '') {
            $consulta = $consulta
                ->groupStart()
                ->like('nombre', $buscar)
                ->orLike('descripcion', $buscar)
                ->groupEnd();
        }

        $datos = [
            'productos' => $consulta->orderBy('id', 'DESC')->findAll(),
            'buscar' => $buscar
        ];

        return view('productos/index', $datos);
    }

    public function guardar()
    {
        $modelo = new ProductosModel();

        $reglas = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'precio' => 'required|decimal|greater_than[0]',
            'stock'  => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->to(base_url('productos'))
                ->with('error', 'Revisá los datos del producto.');
        }

        $modelo->insert([
            'nombre' => $this->request->getPost('nombre'),
            'precio' => $this->request->getPost('precio'),
            'stock'  => $this->request->getPost('stock')
        ]);

        return redirect()->to(base_url('productos'))
            ->with('mensaje', 'Producto agregado correctamente.');
    }

    public function eliminar($id)
    {
        $modelo = new ProductosModel();

        if (!$modelo->find($id)) {
            return redirect()->to(base_url('productos'))
                ->with('error', 'El producto no existe.');
        }

        $modelo->delete($id);

        return redirect()->to(base_url('productos'))
            ->with('mensaje', 'Producto eliminado correctamente.');
    }
}

