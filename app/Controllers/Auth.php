<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Types\User;
use InvalidArgumentException;

class Auth extends BaseController
{
    public function login()
    {
        return view('/auth/login.php');
    }

    public function loginPost()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user && $password == $user['password']) {
            $session->set([
                'userId' => $user['id'],
                'userEmail' => $user['email'],
                'userNickname' => $user['nickname'],
                'loggedIn' => true
            ]);
            return redirect()->to('/tasks');
        } else {
            $session->setFlashdata('error', 'Wrong user or password');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/log_in');
    }

    public function signUp()
    {
        return view('auth/signUp.php');
    }

    public function signUpPost()
    {
        $userModel = new UserModel();

        try {
            $user = new User(
                0,
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
            'active' => true,
        ];

        if (!$userModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->to('/log_in')->with('message', 'Usuario registrado con éxito');
    }
}
