<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth()
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        $data = $usuarioModel->where('usuario', $usuario)->first();

        if ($data) {
            if (password_verify($password, $data['password'])) {
                session()->set('isLoggedIn', true);
                session()->set('usuario', $data['usuario']);
                return redirect()->to('/dashboard'); // Redirigir al dashboard
            } else {
                return redirect()->back()->with('error', 'Contraseña incorrecta');
            }
        } else {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
