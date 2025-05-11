<?php

namespace App\Controllers;

use App\Models\UserModel;
use ReflectionException;

class UserController extends BaseController
{
    public function getOne($nickname)
    {
        $session = session();
        $userModel = new UserModel();

        $currentUser = $userModel->where('id', $session->get('userId'))->first();

        if ($currentUser && $currentUser['nickname'] == $nickname) {
            return view('Users/index', ['user' => $currentUser]);
        }

        //There is an error with the user
        return redirect()->to('/log_out');
    }

    public function update()
    {
        $session = session();
        $userId = $session->get('userId');
        $userModel = new UserModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'nickname' => $this->request->getPost('nickname'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        try {
            if ($userModel->update($userId, $data)) {
                return redirect()->to('/users/' . $data['nickname']);
            }
        } catch (ReflectionException $e) {
            return redirect()->back()->with('error', 'Error al actualizar usuario: ' . $e->getMessage());
        }
    }
}
