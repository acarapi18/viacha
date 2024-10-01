<?php

namespace App\Controllers;

use App\Models\RoleModel;
use CodeIgniter\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();
        return view('roles/index', $data);
    }

    public function store()
    {
        $roleModel = new RoleModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        $roleModel->save($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function getRole($id)
    {
        $roleModel = new RoleModel();
        $role = $roleModel->find($id);
        return $this->response->setJSON($role);
    }

    public function update($id)
    {
        $roleModel = new RoleModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
        ];

        $roleModel->update($id, $data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $roleModel = new RoleModel();
        $roleModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }
}
