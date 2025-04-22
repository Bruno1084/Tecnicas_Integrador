<?php

namespace App\Controllers;

class SubTaskController extends BaseController
{
    public function index(): string
    {
        return view('Subtasks/index.php');
    }
}
