<?php

namespace App\Controllers;

class Supermercados extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $supermercados = $db->table('supermercados')
                            ->orderBy('nombre', 'ASC')
                            ->get()
                            ->getResultArray();

        return view('supermercados/index', [
            'supermercados' => $supermercados
        ]);
    }
}