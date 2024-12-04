<?php

namespace App\Controllers;

use App\Models\UnidadEducativaModel;
use App\Models\MantenimientoModel;
use App\Models\UsuarioModel;
use App\Models\AsignacionModel;
use CodeIgniter\Controller;

class AsignacionController extends Controller
{
    protected $unidadEducativaModel;
    protected $mantenimientoModel;
    protected $usuarioModel;
    protected $asignacionModel;

    public function __construct()
    {
        $this->unidadEducativaModel = new UnidadEducativaModel();
        $this->mantenimientoModel = new MantenimientoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->asignacionModel = new AsignacionModel();
    }

    public function index()
    {
        // Consulta de mantenimientos pendientes
        $pendientes = $this->mantenimientoModel
            ->select('unidad_educativa.codigo_rue, unidad_educativa.nombre, unidad_educativa.telefono, unidad_educativa.id AS id_unidad, COUNT(mantenimiento.id) AS cantidad_equipos, mantenimiento.fecha_solicitud')
            ->join('unidad_educativa', 'unidad_educativa.id = mantenimiento.id_unidad_educativa')
            ->where('mantenimiento.estado_mantenimiento', 'pendiente') // Filtro por estado pendiente
            ->groupBy('unidad_educativa.id, mantenimiento.fecha_solicitud') // Agrupar por unidad y fecha de solicitud
            ->findAll();

        // Consulta de técnicos
        $tecnicos = $this->usuarioModel
            ->where('rol', 'técnico')
            ->select('id, CONCAT(nombre, " ", apellido) AS nombre')
            ->findAll();

        // Consulta de asignaciones realizadas
        $asignaciones = $this->asignacionModel
            ->select('unidad_educativa.nombre AS nombre_unidad, CONCAT(usuarios.nombre, " ", usuarios.apellido) AS nombre_tecnico, asignacion.fecha_asignacion, asignacion.observacion')
            ->join('unidad_educativa', 'unidad_educativa.id = asignacion.id_unidad_educativa')
            ->join('usuarios', 'usuarios.id = asignacion.id_usuario')
            ->findAll();

        $data = [
            'title' => 'Asignar Mantenimiento',
            'pendientes' => $pendientes,
            'tecnicos' => $tecnicos,
            'asignaciones' => $asignaciones
        ];

        return view('asignacion/index', $data);
    }

    public function asignarTecnico()
    {
        if ($this->request->getMethod() == 'post') {
            $unidadId = $this->request->getPost('unidad_id');
            $tecnicoId = $this->request->getPost('tecnico');
            $observacion = $this->request->getPost('observacion');
            $fechaAsignacion = $this->request->getPost('fecha_asignacion');

            if (!$unidadId || !$tecnicoId || !$fechaAsignacion) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Todos los campos son requeridos, excepto la observación.'
                ]);
            }

            $data = [
                'id_unidad_educativa' => $unidadId,
                'id_usuario' => $tecnicoId,
                'observacion' => $observacion,
                'fecha_asignacion' => $fechaAsignacion,
            ];

            if ($this->asignacionModel->save($data)) {
                $this->mantenimientoModel
                    ->where('id_unidad_educativa', $unidadId)
                    ->where('estado_mantenimiento', 'Pendiente')
                    ->set(['estado_mantenimiento' => 'Asignado'])
                    ->update();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'El técnico ha sido asignado correctamente.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error al guardar la asignación. Intente nuevamente.'
                ]);
            }
        }
    }
}
