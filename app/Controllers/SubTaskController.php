<?php

namespace App\Controllers;

use App\Models\SubTaskModel;
use App\Models\TaskModel;

class SubTaskController extends BaseController
{
    public function getAll($idTask)
    {
        $subTaskModel = new SubTaskModel();
        $taskModel = new TaskModel();
    
        $data['task'] = $taskModel->find($idTask);
        $data['subTasks'] = $subTaskModel->where('idTask', $idTask)->findAll();
    
        return view('/SubTasks/index', $data);
    }
}
