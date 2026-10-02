<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Productos extends BaseController
{
    protected $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

   
    public function index()
    {
        $data = [
            'productos' => $this->productoModel->findAll()
        ];

        return view('productos/index', $data);
    }

   
    public function nuevo()
    {
        return view('productos/nuevo');
    }

    
    public function guardar()
    {
        $this->productoModel->save([
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio'      => $this->request->getPost('precio'),
            'stock'       => $this->request->getPost('stock')
        ]);

        return redirect()->to('/productos');
    }

   
    public function editar($id)
    {
        $data = [
            'producto' => $this->productoModel->find($id)
        ];

        return view('productos/editar', $data);
    }

    
    public function actualizar($id)
    {
        $this->productoModel->update($id, [
            'nombre'      => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio'      => $this->request->getPost('precio'),
            'stock'       => $this->request->getPost('stock')
        ]);

        return redirect()->to('/productos');
    }

  
    public function eliminar($id)
    {
        $this->productoModel->delete($id);

        return redirect()->to('/productos');
    }
}
