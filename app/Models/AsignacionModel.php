<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignacionModel extends Model
{
    protected $table = 'asignacion'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria
    protected $allowedFields = [
        'id_unidad_educativa',
        'id_usuario',
        'fecha_asignacion',
        'observacion'
    ];

    // Para el uso de timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

  
}
