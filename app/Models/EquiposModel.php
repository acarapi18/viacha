<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_unidad',
        'serie',
        'marca',
        'modelo',
        'procesador',
        'ram',
        'almacenamiento',
        'accesorios',
        'licencias'
    ];

    protected $useTimestamps = true;
}
