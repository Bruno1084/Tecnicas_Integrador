<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Types\User;
use InvalidArgumentException;
use ReflectionException;

class UserController extends BaseController
{
    // Get Routes
    public function getProfile($idUser)
    {
        $userModel = new UserModel();
        $data = [
            'user' => $userModel->find($idUser),
        ];

        return view('/users/ver_usuario', $data);
    }

    // Update Routes
    public function postUpdate($idUser)
    {
        $userModel = new UserModel();

        try {
            $user = new User(
                $idUser,
                $this->request->getPost('name'),
                $this->request->getPost('nickname'),
                $this->request->getPost('email'),
                $this->request->getPost('password')
            );
        } catch (InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'name' => $user->getName(),
            'nickname' => $user->getNickname(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ];

        if (!$userModel->update($idUser, $data)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        // Buscar los datos actualizados como array
        $updatedUser = $userModel->find($idUser);

        return view('/users/ver_usuario', ['user' => $updatedUser]);
    }
}
