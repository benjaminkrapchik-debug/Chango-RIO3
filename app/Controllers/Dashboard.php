<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('usuario_id')) {
            return redirect()->to(base_url('login'))
                ->with('error', 'Iniciá sesión para continuar.');
        }

        return view('dashboard');
    }
}