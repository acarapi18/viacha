<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    protected $table = 'inventario';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_unidad_educativa', // actualizado
        'id_usuario',
        'serie',
        'marca',
        'modelo',
        'procesador',
        'ram',
        'almacenamiento',
        'estado',
        'observacion',
        'cargador',           // nuevo campo
        'cable_poder',        // nuevo campo
        'lupa',               // nuevo campo
        'termico',            // nuevo campo
        'lapiz_optico',       // nuevo campo
        'bateria',            // nuevo campo
        'licencia_office',     // nuevo campo
        'licencia_windows'     // nuevo campo
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
