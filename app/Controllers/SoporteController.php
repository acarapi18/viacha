<?php

namespace App\Controllers;

use App\Models\MantenimientoModel;
use App\Models\UnidadEducativaModel;
use App\Models\EquiposModel;
use App\Models\AsignacionModel;

class SoporteController extends BaseController
{
    protected $mantenimientoModel;
    protected $unidadEducativaModel;
    protected $equiposModel;
    protected $asignacionModel;

    public function __construct()
    {
        // Instancia de modelos
        $this->mantenimientoModel = new MantenimientoModel();
        $this->unidadEducativaModel = new UnidadEducativaModel();
        $this->equiposModel = new EquiposModel();
        $this->asignacionModel = new AsignacionModel();
    }

    // Mostrar la vista principal con las unidades educativas asignadas al usuario logueado
    public function index()
    {
        $data['title'] = 'Soporte de Equipos';
        $usuarioId = session()->get('user_id'); // Obtener el ID del usuario logueado desde la sesión

        // Obtener las unidades educativas asignadas al usuario logueado
        $asignaciones = $this->asignacionModel->where('id_usuario', $usuarioId)->findAll();

        // Extraer los IDs de las unidades educativas asignadas
        $unidadIds = array_column($asignaciones, 'id_unidad_educativa');

        if (empty($unidadIds)) {
            return view('soporte/index', [
                'title' => 'Soporte de Equipos',
                'message' => 'No tienes unidades educativas asignadas.'
            ]);
        }

        // Obtener las unidades educativas asignadas
        $data['unidades'] = $this->unidadEducativaModel->whereIn('id', $unidadIds)->findAll();

        return view('soporte/index', $data);
    }

    // Obtener equipos asociados a una unidad educativa asignados al usuario logueado
    public function getByUnidad($unidadId)
    {
        $usuarioId = session()->get('user_id'); // Obtener el ID del usuario logueado

        // Validar si la unidad educativa está asignada al usuario
        $asignacion = $this->asignacionModel->where('id_usuario', $usuarioId)
            ->where('id_unidad_educativa', $unidadId)
            ->first();

        if (!$asignacion) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No tienes acceso a esta unidad educativa.'
            ]);
        }

        // Obtener los IDs de equipos asociados a mantenimientos asignados al usuario
        $equiposIds = $this->mantenimientoModel->select('id_equipo')
            ->whereIn('id_equipo', function ($builder) use ($unidadId) {
                $builder->select('id')
                    ->from('equipos')
                    ->where('id_unidad_educativa', $unidadId);
            })
            ->groupBy('id_equipo')
            ->findAll();

        if (empty($equiposIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se encontraron equipos con mantenimiento asignado.'
            ]);
        }

        // Obtener información detallada de los equipos
        $equipos = $this->equiposModel->whereIn('id', array_column($equiposIds, 'id_equipo'))->findAll();

        // Enriquecer datos con información de mantenimiento
        foreach ($equipos as &$equipo) {
            $mantenimiento = $this->mantenimientoModel->where('id_equipo', $equipo['id'])->first();
            $equipo['tipo_mantenimiento'] = $mantenimiento ? $mantenimiento['tipo_mantenimiento'] : 'N/A';
            $equipo['fecha_mantenimiento'] = $mantenimiento ? $mantenimiento['fecha_solicitud'] : 'N/A';
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $equipos
        ]);
    }

    // Obtener un equipo por su ID si está asignado al usuario logueado
    public function getById($equipoId)
    {
        $usuarioId = session()->get('user_id'); // Obtener el ID del usuario logueado

        // Validar si el equipo tiene mantenimiento asignado al usuario
        $mantenimiento = $this->mantenimientoModel->where('id_equipo', $equipoId)
            ->whereIn('id_equipo', function ($builder) use ($usuarioId) {
                $builder->select('id_equipo')
                    ->from('asignacion')
                    ->where('id_usuario', $usuarioId);
            })
            ->first();

        if (!$mantenimiento) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No tienes acceso a este equipo.'
            ]);
        }

        $equipo = $this->equiposModel->find($equipoId);

        if ($equipo) {
            $equipo['tipo_mantenimiento'] = $mantenimiento['tipo_mantenimiento'] ?? 'N/A';
            $equipo['fecha_mantenimiento'] = $mantenimiento['fecha_solicitud'] ?? 'N/A';

            return $this->response->setJSON([
                'success' => true,
                'data' => $equipo
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Equipo no encontrado.'
        ]);
    }
}
