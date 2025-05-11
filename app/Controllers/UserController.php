<?php

namespace App\Controllers;

use App\Models\UserModel;

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
}
