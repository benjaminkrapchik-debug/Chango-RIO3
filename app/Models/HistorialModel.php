<?php

namespace App\Models;

use CodeIgniter\Model;

class HistorialModel extends Model
{
    protected $table = 'historial';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id',
        'actividad',
        'detalles',
        'fecha_hora'
    ];

    protected $useTimestamps = false;
}