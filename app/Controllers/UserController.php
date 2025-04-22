<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index(): string
    {
        return view('Users/index');
    }

    public function getAll()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return $this->response->setJSON($users);
    }

    public function getOne($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario con ID $id no encontrado.");
        }

        return $this->response->setJSON($user);
    }

    public function create()
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true);

        if (!$userModel->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'No se pudo crear el usuario',
                'errors' => $userModel->errors()
            ]);
        }

        //Returns a 201 code and the created user Data
        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'Usuario creado correctamente',
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true);

        if (!$userModel->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => "Usuario con ID $id no encontrado"
            ]);
        }

        if (!$userModel->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'No se pudo actualizar el usuario',
                'errors' => $userModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        if (!$userModel->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => "Usuario con ID $id no encontrado"
            ]);
        }

        $userModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "Usuario con ID $id eliminado correctamente"
        ]);
    }
}
