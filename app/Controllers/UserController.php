<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index(): string
    {
        return view('Users/index');
    }

    public function getAll() {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('Users/index', ['users' => $users]);
    }
}
