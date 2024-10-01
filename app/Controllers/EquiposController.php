<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use CodeIgniter\Controller;

class EquiposController extends Controller
{
    public function index()
    {
        return view('equipos/index');
    }

    // Obtener las unidades educativas activas para el Select2
    public function getUnidadesEducativas()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('unidad_educativa');
        $builder->select('id, codigo_rue, nombre');
        $builder->where('estado', 'Activo');
        $query = $builder->get();

        $unidades = $query->getResult();

        // Formatear la respuesta para que sea compatible con Select2
        $data = [];
        foreach ($unidades as $unidad) {
            $data[] = [
                'id' => $unidad->id,
                'text' => $unidad->codigo_rue . ' - ' . $unidad->nombre
            ];
        }

        return $this->response->setJSON(['results' => $data]);
    }


    // Guardar los equipos en la base de datos
    public function guardar()
    {
        $equipoModel = new EquipoModel();
        $equipos = $this->request->getPost('equipos');

        foreach ($equipos as $equipo) {
            $data = [
                'id_unidad' => $equipo['id_unidad'],
                'serie' => $equipo['serie'],
                'marca' => $equipo['marca'],
                'modelo' => $equipo['modelo'],
                'procesador' => $equipo['procesador'],
                'ram' => $equipo['ram'],
                'almacenamiento' => $equipo['almacenamiento'],
                'accesorios' => $equipo['accesorios'],
                'licencias' => $equipo['licencias'],
            ];
            $equipoModel->insert($data);
        }

        return $this->response->setJSON(['status' => 'success']);
    }
}
