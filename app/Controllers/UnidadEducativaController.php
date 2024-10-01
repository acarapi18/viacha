<?php

namespace App\Controllers;

use App\Models\UnidadEducativaModel;
use App\Models\UsuarioModel; // Importar el modelo de usuario
use CodeIgniter\Controller;

class UnidadEducativaController extends Controller
{
    protected $unidadEducativaModel;
    protected $usuarioModel; // Definir el modelo de usuario

    public function __construct()
    {
        $this->unidadEducativaModel = new UnidadEducativaModel();
        $this->usuarioModel = new UsuarioModel(); // Inicializar el modelo de usuario
    }

    public function index()
    {
        $data['unidades'] = $this->unidadEducativaModel->findAll();
        $data['usuarios'] = $this->usuarioModel->findAll(); // Obtener todos los usuarios
        return view('unidad_educativa/index', $data);
    }

    public function store()
    {
        $this->unidadEducativaModel->save([
            'codigo_rue' => $this->request->getPost('codigo_rue'),
            'nombre' => $this->request->getPost('nombre'),
            'direccion' => $this->request->getPost('direccion'),
            'dependencia' => $this->request->getPost('dependencia'),
            'area_geografica' => $this->request->getPost('area_geografica'),
            'estado' => $this->request->getPost('estado'),
            'usuario_id' => $this->request->getPost('usuario_id') // Guardar el usuario seleccionado
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $this->unidadEducativaModel->update($id, [
            'codigo_rue' => $this->request->getPost('codigo_rue'),
            'nombre' => $this->request->getPost('nombre'),
            'direccion' => $this->request->getPost('direccion'),
            'dependencia' => $this->request->getPost('dependencia'),
            'area_geografica' => $this->request->getPost('area_geografica'),
            'estado' => $this->request->getPost('estado'),
            'usuario_id' => $this->request->getPost('usuario_id') // Actualizar el usuario seleccionado
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $this->unidadEducativaModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function getUnidadEducativa($id)
    {
        $unidad = $this->unidadEducativaModel->find($id);
        return $this->response->setJSON($unidad);
    }

    public function search()
    {
        $model = new UnidadEducativaModel();
        $searchTerm = $this->request->getGet('q'); // El término de búsqueda

        // Busca por nombre o código RUE
        $result = $model->like('nombre', $searchTerm)
            ->orLike('codigo_rue', $searchTerm)
            ->findAll();

        $data = [];
        foreach ($result as $unidad) {
            $data[] = [
                'id' => $unidad['id'],
                'text' => $unidad['nombre'] . ' - ' . $unidad['codigo_rue']
            ];
        }

        return $this->response->setJSON($data);
    }
}
