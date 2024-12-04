<?php 

namespace App\Controllers;

use App\Models\UsuarioModel;

class DashboardController extends BaseController
{
    public function admin()
    {
        $session = session();

        // Verificar si el usuario está logueado y tiene el rol adecuado
        if (!$this->isLoggedIn($session) || $session->get('rol') !== 'Administrador') {
            return $this->redirectToLogin();
        }

        // Preparar los datos específicos para el dashboard del Administrador
        $data = [
            'title' => 'Dashboard - Administrador',
            'usuario' => $session->get('nombre'),
            'apellido' => $session->get('apellido'),
            'rol' => $session->get('rol'),
            
        ];

        // Cargar la vista del dashboard del Administrador
        return view('dashboard/admin', $data);
    }

    public function tecnico()
    {
        $session = session();

        // Verificar si el usuario está logueado y tiene el rol adecuado
        if (!$this->isLoggedIn($session) || $session->get('rol') !== 'Técnico') {
            return $this->redirectToLogin();
        }

        // Preparar los datos específicos para el dashboard del Técnico
        $data = [
            'title' => 'Dashboard - Técnico',
            'usuario' => $session->get('nombre'),
            'apellido' => $session->get('apellido'),
            'rol' => $session->get('rol'),
            'nombre_unidad_educativa' => $session->get('nombre_unidad_educativa'),
            'id_unidad_educativa' => $session->get('id_unidad_educativa'),
        ];

        // Cargar la vista del dashboard del Técnico
        return view('dashboard/tecnico', $data);
    }

    public function encargado()
    {
        $session = session();

        // Verificar si el usuario está logueado y tiene el rol adecuado
        if (!$this->isLoggedIn($session) || $session->get('rol') !== 'Encargado') {
            return $this->redirectToLogin();
        }

        // Preparar los datos específicos para el dashboard del Encargado
        $data = [
            'title' => 'Dashboard - Encargado',
            'usuario' => $session->get('nombre'),
            'apellido' => $session->get('apellido'),
            'rol' => $session->get('rol'),
            'nombre_unidad_educativa' => $session->get('nombre_unidad_educativa'),
            'id_unidad_educativa' => $session->get('id_unidad_educativa'),
        ];

        // Cargar la vista del dashboard del Encargado
        return view('dashboard/encargado', $data);
    }

    // Método para verificar si el usuario está logueado
    private function isLoggedIn($session)
    {
        return $session->get('isLoggedIn');
    }

    // Método para redirigir al usuario a la página de inicio de sesión
    private function redirectToLogin()
    {
        return redirect()->to('/login');
    }
}
