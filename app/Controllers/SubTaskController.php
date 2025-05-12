<?php

namespace App\Controllers;

use App\Models\SubTaskModel;
use App\Models\TaskModel;
use App\Models\UserModel;

class SubTaskController extends BaseController
{
    public function getAll($idTask)
    {
        $session = session();

        $subTaskModel = new SubTaskModel();
        $taskModel = new TaskModel();
        $userModel = new UserModel();
    
        $data['task'] = $taskModel->find($idTask);
        $data['subTasks'] = $subTaskModel->where('idTask', $idTask)->findAll();
        $data['responsible'] = $userModel->where('id', $session->get('userId'))->first();
        return view('/SubTasks/index', $data);
    }

    public function getOne($idSubTask) {
        
    }
}
