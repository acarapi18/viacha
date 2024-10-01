<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadEducativaModel extends Model
{
    protected $table = 'unidad_educativa';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo_rue',
        'nombre',
        'direccion',
        'dependencia',
        'area_geografica',
        'estado',
        'id_usuario'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUnidadesActivas()
    {
        return $this->where('estado', 'Activo')->findAll();
    }
}
