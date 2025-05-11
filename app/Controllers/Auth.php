<?php

namespace App\Controllers;

use App\Models\UserModel;

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
                'userNickname' =>$user['nickname'],
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
        $model = new UserModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'nickname' => $this->request->getPost('nickname'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'active' => true,
        ];

        if (!$model->insert($data)) {
            print_r($model->errors());
        } else {
            return redirect()->to('/login');
        }
    }
}
