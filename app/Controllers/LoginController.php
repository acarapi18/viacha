<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\UnidadEducativaModel; // Cargar el modelo de unidad educativa
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        // Cargar la vista del formulario de login
        return view('login');
    }

    public function authenticate()
    {
        $session = session();
        $usuarioModel = new UsuarioModel();
        $unidadEducativaModel = new UnidadEducativaModel(); // Instancia del modelo de unidad educativa

        $usuario = $this->request->getVar('usuario');
        $password = $this->request->getVar('password');

        // Buscar el usuario por su nombre de usuario
        $user = $usuarioModel->where('usuario', $usuario)->first();

        if ($user) {
            // Verificar si el usuario está activo
            if ($user['estado'] == 'Activo') {
                // Verificar la contraseña
                if (password_verify($password, $user['password'])) {
                    // Obtener el nombre de la unidad educativa
                    $unidadEducativa = $unidadEducativaModel->find($user['id_unidad_educativa']);

                    if ($unidadEducativa) {
                        // Establecer la sesión del usuario, incluyendo el nombre de la unidad educativa
                        $session->set([
                            'user_id' => $user['id'],
                            'nombre' => $user['nombre'],
                            'apellido' => $user['apellido'],
                            'usuario' => $user['usuario'],
                            'rol' => $user['rol'],
                            'id_unidad_educativa' => $user['id_unidad_educativa'],
                            //'nombre_unidad_educativa' => $unidadEducativa['nombre'], // Agregar el nombre de la unidad educativa
                            'isLoggedIn' => true,
                        ]);

                        // Redirigir al dashboard correspondiente según el rol
                        switch ($user['rol']) {
                            case 'Administrador':
                                return redirect()->to('/dashboard/admin');
                            case 'Técnico':
                                return redirect()->to('/dashboard/tecnico');
                            case 'Encargado':
                                return redirect()->to('/dashboard/encargado');
                            default:
                                $session->setFlashdata('error', 'Rol de usuario desconocido');
                                return redirect()->back();
                        }
                    } else {
                        // No se encontró la unidad educativa
                        $session->setFlashdata('error', 'Unidad educativa no encontrada');
                        return redirect()->back();
                    }
                } else {
                    // Contraseña incorrecta
                    $session->setFlashdata('error', 'Contraseña incorrecta');
                    return redirect()->back();
                }
            } else {
                // Usuario inactivo
                $session->setFlashdata('error', 'Usuario inactivo');
                return redirect()->back();
            }
        } else {
            // Usuario no encontrado
            $session->setFlashdata('error', 'Usuario no encontrado');
            return redirect()->back();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
