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
        $usuarioId = $this->usuarioId();

        if (!$usuarioId || !session()->get('logueado')) {
            return redirect()->to(base_url('login'));
        }

        $historial = $this->historialModel
            ->where('usuario_id', $usuarioId)
            ->orderBy('fecha_hora', 'DESC')
            ->findAll();

        $datos = [
            'titulo' => 'Historial - CHANGO RIO 3',
            'historial' => $historial
        ];

        return view('historial/index', $datos);
    }
}