<?php 

namespace App\Models;

use CodeIgniter\Model;

class MantenimientoModel extends Model
{
    protected $table = 'mantenimiento';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_unidad_educativa', 
        'id_usuario',
        'id_equipo', 
        'serie',
        'marca',
        'modelo',        
        'tipo_mantenimiento',
        'estado_mantenimiento', 
        'fecha_solicitud', 
        'fecha_finalizacion', 
        'observaciones'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    

}
