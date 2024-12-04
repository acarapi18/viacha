<?php

namespace App\Controllers;

use App\Models\EquiposModel;
use App\Models\InventarioModel;
use CodeIgniter\Controller;

class InventarioController extends Controller
{
    protected $equiposModel;
    protected $inventarioModel;

    public function __construct()
    {
        $this->equiposModel = new EquiposModel();
        $this->inventarioModel = new InventarioModel();
    }

    public function index()
    {
        $data['title'] = 'Inventario de Equipos';
        return view('inventario/index', $data);
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

    public function modificarEquipo()
{
    $data = $this->request->getPost();
    $data['id_usuario'] = session()->get('user_id');
    $data['id_unidad_educativa'] = session()->get('id_unidad_educativa');
    $fechaHoy = date('Y-m-d');

    // Verificar si ya existe un registro para la misma serie en el día actual
    $existe = $this->inventarioModel
        ->where('serie', $data['serie'])
        ->where('DATE(created_at)', $fechaHoy)
        ->first();

    if ($existe) {
        return $this->response->setJSON([
            'status' => 'duplicate',
            'message' => 'Este equipo ya ha sido inventariado hoy. Por favor, verifica los datos.'
        ]);
    }

    // Intentar guardar o actualizar los datos del equipo
    if ($this->inventarioModel->save($data)) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Equipo modificado correctamente'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Error al modificar el equipo'
        ]);
    }
}


        // Listar equipos inventariados solo con la fecha actual y según el usuario logueado y unidad educativa
        public function listarEquiposInventariados()
        {
            // Obtener el ID del usuario logueado y su unidad educativa
            $userId = session()->get('user_id');
            $unidadEducativaId = session()->get('id_unidad_educativa');
    
            // Filtrar equipos por la fecha actual, usuario y unidad educativa
            $equipos = $this->inventarioModel
                ->where('DATE(created_at)', date('Y-m-d'))
                ->where('id_usuario', $userId)
                ->where('id_unidad_educativa', $unidadEducativaId)
                ->findAll();
    
            // Mapear los datos para que sean compatibles con DataTables
            $data = array_map(function($equipo) {
                return [
                    'id' => $equipo['id'],
                    'estado' => $equipo['estado'],
                    'serie' => $equipo['serie'],
                    'marca' => $equipo['marca'],
                    'modelo' => $equipo['modelo'],
                    'ram' => $equipo['ram'],
                    'almacenamiento' => $equipo['almacenamiento'],
                    'accesorios' => $this->formatearAccesorios($equipo),
                    'licencias' => $this->formatearLicencias($equipo),
                ];
            }, $equipos);
    
            return $this->response->setJSON(['data' => $data]);
        }
    
        // Formatear los accesorios para mostrar en la tabla
        private function formatearAccesorios($equipo)
        {
            $accesorios = [];
            if ($equipo['cargador']) $accesorios[] = 'Cargador';
            if ($equipo['cable_poder']) $accesorios[] = 'Cable de Poder';
            if ($equipo['lupa']) $accesorios[] = 'Lupa';
            if ($equipo['termico']) $accesorios[] = 'Térmico';
            if ($equipo['lapiz_optico']) $accesorios[] = 'Lápiz Óptico';
            if ($equipo['bateria']) $accesorios[] = 'Batería';
    
            return implode(', ', $accesorios);
        }
    
        // Formatear las licencias para mostrar en la tabla
        private function formatearLicencias($equipo)
        {
            $licencias = [];
            if ($equipo['licencia_office']) $licencias[] = 'Office';
            if ($equipo['licencia_windows']) $licencias[] = 'Windows';
    
            return implode(', ', $licencias);
        }

        public function eliminarEquipo()
        {
            $serie = $this->request->getPost('serie');

            if (!$serie) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Número de serie no proporcionado.'
                ]);
            }

            $inventarioModel = new \App\Models\InventarioModel();

            // Intentar eliminar el equipo
            if ($inventarioModel->where('serie', $serie)->delete()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Equipo eliminado exitosamente.'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al eliminar el equipo. Intenta nuevamente.'
            ]);
        }

            
    
}
