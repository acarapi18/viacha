<?php

namespace App\Controllers;

use App\Models\EquiposModel;
use App\Models\MantenimientoModel;
use CodeIgniter\Controller;

class MantenimientoController extends Controller
{
    protected $equiposModel;
    protected $mantenimientoModel;

    public function __construct()
    {
        $this->equiposModel = new EquiposModel();
        $this->mantenimientoModel = new MantenimientoModel();
    }

    public function index()
    {
        $data['title'] = 'Reportar Mantenimiento'; // Título de la página
        return view('mantenimiento/index', $data);
    }

    // Listar equipos reportados para mantenimiento
    public function listarEquiposReportados()
    {
        // Obtener el ID del usuario logueado y su unidad educativa
        $userId = session()->get('user_id');
        $unidadEducativaId = session()->get('id_unidad_educativa');
    
        // Consulta para obtener los equipos reportados
        $equipos = $this->mantenimientoModel
            ->select('mantenimiento.id_equipo, equipos.serie, equipos.marca, equipos.modelo, mantenimiento.tipo_mantenimiento')
            ->join('equipos', 'equipos.id = mantenimiento.id_equipo')
            ->where('DATE(mantenimiento.created_at)', date('Y-m-d'))
            ->where('mantenimiento.id_usuario', $userId)
            ->where('equipos.id_unidad_educativa', $unidadEducativaId)
            ->get()
            ->getResultArray(); // Usar getResultArray para obtener los datos como array
    
        // Mapear los datos para que sean compatibles con DataTables
        $data = array_map(function ($equipo) {
            return [
                'id_equipo' => $equipo['id_equipo'],
                'serie' => $equipo['serie'],
                'marca' => $equipo['marca'],
                'modelo' => $equipo['modelo'],
                'mantenimiento' => $equipo['tipo_mantenimiento'],
            ];
        }, $equipos);
    
        // Retornar datos en formato JSON
        return $this->response->setJSON(['data' => $data]);
    }
        
    public function buscarPorSerie()
    {
        $serie = $this->request->getGet('serie');
        $userId = session()->get('user_id');
        $unidadEducativaId = session()->get('id_unidad_educativa');

        if (empty($serie)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Serie no proporcionada']);
        }

        $result = $this->equiposModel
            ->where('serie', $serie)
            ->where('id_usuario', $userId)
            ->where('id_unidad_educativa', $unidadEducativaId)
            ->findAll();

        if (!$result) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Equipo no encontrado']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $result]);
    }

    public function obtenerEquipo()
    {
        $id = $this->request->getGet('id');
        $userId = session()->get('user_id');
        $unidadEducativaId = session()->get('id_unidad_educativa');

        if (empty($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID no proporcionado']);
        }

        $equipo = $this->equiposModel
            ->where('id', $id)
            ->where('id_usuario', $userId)
            ->where('id_unidad_educativa', $unidadEducativaId)
            ->first();

        if (!$equipo) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Equipo no encontrado']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $equipo]);
    }

    public function registrarMantenimiento()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'id_unidad_educativa' => session()->get('id_unidad_educativa'),
                'id_usuario' => session()->get('user_id'),
                'id_equipo' => $this->request->getPost('id_equipo'),
                'tipo_mantenimiento' => $this->request->getPost('tipoMantenimiento'),  
                'estado_mantenimiento' => 'Pendiente',
                'fecha_solicitud' => date('Y-m-d'),
                'observaciones' => $this->request->getPost('observaciones')
            ];
    
            // Guardar datos y retornar JSON con éxito o error
            if ($this->mantenimientoModel->save($data)) {
                return $this->response->setJSON(['success' => 'Mantenimiento registrado exitosamente']);
            } else {
                return $this->response->setJSON(['error' => 'Error al registrar mantenimiento'], 500);
            }
        }
        return $this->response->setJSON(['error' => 'Método no permitido'], 405);
    }
        
    public function actualizarEstado()
    {
        $idMantenimiento = $this->request->getPost('id_mantenimiento');
        $estadoMantenimiento = $this->request->getPost('estado_mantenimiento');

        $this->mantenimientoModel->update($idMantenimiento, [
            'estado_mantenimiento' => $estadoMantenimiento,
            'fecha_finalizacion' => ($estadoMantenimiento == 'Completado') ? date('Y-m-d') : null
        ]);

        return $this->response->setJSON(['success' => 'Estado de mantenimiento actualizado']);
    }


    public function eliminarEquipo()
    {
        $idEquipo = $this->request->getPost('id_equipo');
        
        if (!$idEquipo) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID del equipo no proporcionado.'
            ]);
        }

        $deleted = $this->mantenimientoModel->delete($idEquipo);

        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'El equipo fue eliminado correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se pudo eliminar el equipo. Verifica si el ID es correcto.'
            ]);
        }
    }
                
}
