<?php

namespace App\Controllers;

class TaskController extends BaseController
{
    public function index(): string
    {
        return view('/Tasks/index.php');
    }
}
