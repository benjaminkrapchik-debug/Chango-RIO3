<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
 {
    public function index()
    {
        return view('producto/index');
    }
}

    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'stock'
    ];

    protected $useTimestamps = false;
}
