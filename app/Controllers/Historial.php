<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistorialModel;

class Historial extends BaseController
{
    protected $historialModel;

    public function __construct()
    {
        $this->historialModel = new HistorialModel();
    }

    private function usuarioId()
    {
        return session()->get('usuario_id')
            ?? session()->get('id');
    }

    public function index()
    {
        $db = \Config\Database::connect();
    
        $usuarioId = session()->get('usuario_id');
    
        $compras = $db->table('compras')
            ->where('usuario_id', $usuarioId)
            ->orderBy('fecha', 'DESC')
            ->get()
            ->getResultArray();
    
        foreach ($compras as $i => $compra) {
    
            $productos = $db->table('detalle_compras')
                ->where('compra_id', $compra['id'])
                ->get()
                ->getResultArray();
    
            $compras[$i]['productos'] = $productos;
        }
    
        return view('historial/index', [
            'compras' => $compras
        ]);
    }
}