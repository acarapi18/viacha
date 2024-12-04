<?php

namespace App\Controllers;

use App\Models\UnidadEducativaModel;
use App\Models\EquiposModel;
use App\Models\MantenimientoModel; 
use CodeIgniter\Controller;

class EquiposController extends Controller
{
    protected $equiposModel;
    protected $unidadEducativaModel;
    protected $mantenimientoModel;


    public function __construct()
    {
        $this->equiposModel = new EquiposModel();
        $this->unidadEducativaModel = new UnidadEducativaModel();
        $this->mantenimientoModel = new MantenimientoModel(); 

    }

    public function index()
    {
        $data['title'] = 'Gestión de Equipos';
        // Obtener el id de la unidad educativa desde la sesión
        $idUnidadEducativa = session()->get('id_unidad_educativa');

        // Filtrar equipos por id_unidad_educativa
        $data['equipos'] = $this->equiposModel->where('id_unidad_educativa', $idUnidadEducativa)->findAll();

        return view('equipos/index', $data);
    }

    public function store()
    {
        // Obtener el id de la unidad educativa y del usuario desde la sesión
        $idUnidadEducativa = session()->get('id_unidad_educativa');
        $idUsuario = session()->get('user_id'); // Obtener el id del usuario logueado

        // Lógica para manejar los valores de los checkboxes (1 si está seleccionado, 0 si no)
        $checkboxFields = ['cargador', 'cable_poder', 'lupa', 'termico', 'lapiz_optico', 'bateria', 'licencia_office', 'licencia_windows'];
        $checkboxData = [];
        foreach ($checkboxFields as $field) {
            $checkboxData[$field] = $this->request->getPost($field) ? 1 : 0;
        }

        // Obtener la serie del formulario
        $serie = $this->request->getPost('serie');

        // Verificar si ya existe un registro con la misma serie
        $existingEquipo = $this->equiposModel->where('serie', $serie)->first();

        if ($existingEquipo) {
            // Obtener el nombre de la unidad educativa donde está registrado
            $unidadEducativa = $this->unidadEducativaModel->find($existingEquipo['id_unidad_educativa']);
            $nombreUnidadEducativa = $unidadEducativa ? $unidadEducativa['nombre'] : 'desconocida';

            // Retornar un error indicando dónde está registrado
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "El equipo con serie '$serie' ya está registrado en la unidad educativa '$nombreUnidadEducativa'."
            ]);
        }

        // Preparar los datos para guardar
        $data = [
            'id_unidad_educativa' => $idUnidadEducativa,
            'id_usuario' => $idUsuario, // Almacenar el id del usuario que crea el registro
            'serie' => $serie,
            'marca' => $this->request->getPost('marca'),
            'modelo' => $this->request->getPost('modelo'),
            'procesador' => $this->request->getPost('procesador'),
            'ram' => $this->request->getPost('ram'),
            'almacenamiento' => $this->request->getPost('almacenamiento'),
            'estado' => $this->request->getPost('estado'),
            'observacion' => $this->request->getPost('observacion') ?? null, // Campo opcional
        ];

        // Fusionar los datos del formulario con los valores de los checkboxes
        $data = array_merge($data, $checkboxData);

        // Guardar los datos en la base de datos
        if ($this->equiposModel->save($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo guardar el registro.']);
        }
    }
        
    public function update($id)
    {
        // Obtener el id de la unidad educativa y del usuario desde la sesión
        $idUnidadEducativa = session()->get('id_unidad_educativa');
        $idUsuario = session()->get('user_id'); // Obtener el id del usuario logueado

        // Lógica para manejar los valores de los checkboxes (1 si está seleccionado, 0 si no)
        $checkboxFields = ['cargador', 'cable_poder', 'lupa', 'termico', 'lapiz_optico', 'bateria', 'licencia_office', 'licencia_windows'];
        $checkboxData = [];
        foreach ($checkboxFields as $field) {
            $checkboxData[$field] = $this->request->getPost($field) ? 1 : 0;
        }
    
        // Preparar los datos para la actualización
        $data = [
            'id_unidad_educativa' => $idUnidadEducativa,
            'id_usuario' => $idUsuario, // Almacenar el id del usuario que actualiza el registro            
            'ram' => $this->request->getPost('ram'),
            'almacenamiento' => $this->request->getPost('almacenamiento'),
            'estado' => $this->request->getPost('estado'),
            'observacion' => $this->request->getPost('observacion'), // Campo opcional
        ];
    
        // Fusionar los datos principales con los valores de los checkboxes
        $data = array_merge($data, $checkboxData);
    
        // Actualizar los datos en la base de datos
        if ($this->equiposModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar el registro.']);
        }
    }
    
    public function delete($id)
    {
        // Verificar si el equipo tiene registros en la tabla mantenimiento
        $hasMaintenanceRecords = $this->mantenimientoModel->where('id_equipo', $id)->countAllResults();

        if ($hasMaintenanceRecords > 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se puede eliminar el equipo porque tiene registros de mantenimiento asociados.'
            ]);
        }

        // Eliminar el equipo si no tiene registros asociados
        if ($this->equiposModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo eliminar el equipo.']);
        }
    }
    
    public function getEquipos($id)
    {
        $equipos = $this->equiposModel->find($id);
        return $this->response->setJSON($equipos);
    }


}
