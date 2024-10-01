<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('usuarios/index', $data);
    }

    public function store()
    {
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // Hash de la contraseña
        $this->usuarioModel->save([
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'usuario' => $this->request->getPost('usuario'),
            'password' => $password,
            'rol' => $this->request->getPost('rol'),
            'estado' => $this->request->getPost('estado')
        ]);

        return $this->response->setJSON(['status' => 'success']);
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
            'estado' => $this->request->getPost('estado')
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
        $model = new UsuarioModel();
        $data = ['password' => $hashed_password];
        if ($model->update($id, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'No se pudo actualizar la contraseña']);
        }
    }
}
