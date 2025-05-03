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
        return redirect()->to('/login');
    }
}
