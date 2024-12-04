<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\UnidadEducativaModel;  // Importar el modelo de unidad educativa
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    protected $usuarioModel;
    protected $unidadEducativaModel; // Definir el modelo de unidad educativa

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->unidadEducativaModel = new UnidadEducativaModel(); // Inicializar el modelo
    }

    public function index()
    {
        $data['title'] = 'Gestión de Usuarios'; // Título de la página
        // Traer solo las unidades educativas que están activas (estado = 'Activo')
        $data['usuarios'] = $this->usuarioModel->findAll();
        $data['unidades'] = $this->unidadEducativaModel->where('estado', 'Activo')->findAll();  // Filtrar por estado
        return view('usuarios/index', $data);
    }

    public function store()
    {
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // Hash de la contraseña
    
        // Validación de los datos antes de guardar
        if ($this->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'usuario' => 'required|is_unique[usuarios.usuario]',  // Asegura que el nombre de usuario sea único
            'password' => 'required|min_length[8]',
            'rol' => 'required',
            'estado' => 'required',
        ])) {
            $this->usuarioModel->save([
                'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
                'usuario' => $this->request->getPost('usuario'),
                'password' => $password,
                'rol' => $this->request->getPost('rol'),
                'estado' => $this->request->getPost('estado'),
                'id_unidad_educativa' => $this->request->getPost('id_unidad_educativa')  // Corregir nombre del campo
            ]);
    
            return $this->response->setJSON(['status' => 'success', 'message' => 'Usuario creado con éxito']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
        }
    }
    
    public function update($id)
    {
        $password = $this->request->getPost('password');
        if ($password) {
            $password = password_hash($password, PASSWORD_DEFAULT); // Actualizar contraseña
        } else {
            $password = $this->usuarioModel->find($id)['password']; // Mantener la anterior
        }

        $this->usuarioModel->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'usuario' => $this->request->getPost('usuario'),
            'password' => $password,
            'id_rol' => $this->request->getPost('id_rol'),
            'estado' => $this->request->getPost('estado'),
            'id_unidad_educativa' => $this->request->getPost('id_unidad_educativa')  // Corregir nombre del campo
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $this->usuarioModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function getUsuario($id)
    {
        $usuario = $this->usuarioModel->find($id);
        return $this->response->setJSON($usuario);
    }

    public function cambiarPassword()
    {
        $id = $this->request->getPost('id');
        $nueva_password = $this->request->getPost('password');

        if (!$id || !$nueva_password) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos inválidos']);
        }

        // Encriptar la nueva contraseña
        $hashed_password = password_hash($nueva_password, PASSWORD_DEFAULT);

        // Actualizar en la base de datos
        $data = ['password' => $hashed_password];
        if ($this->usuarioModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar la contraseña']);
        }
    }
}
