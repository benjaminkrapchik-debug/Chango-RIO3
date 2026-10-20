<?php
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    public function index()
    {
        $productoModel = new ProductoModel();

        $datos['productos'] = $productoModel->findAll();

        return view('producto/index', $datos);
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
