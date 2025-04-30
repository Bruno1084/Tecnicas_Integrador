<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    public function index(): string
    {
        $taskModel = new TaskModel();
        $data['tasks'] = $taskModel->findAll();

        return view('/Tasks/index', $data);
    }

    public function getOne($id)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($id);

        if (!$task) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Task not found - TaskController getOne function");
        }

        return $this->response->setJSON($task);
    }

    public function create()
    {
        $taskModel = new TaskModel();
        $data = $this->request->getJSON(true);

        if (!$taskModel->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'It was not posible to create the task',
                'errors' => $taskModel->errors()
            ]);
        }

        //Returns a 201 code and the created user Data
        return $this->response->setStatusCode(201)->setJSON([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $taskModel = new TaskModel();
        $data = $this->request->getJSON(true);

        if (!$taskModel->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => "Task not found - TaskController update function"
            ]);
        }

        if (!$taskModel->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'it was not posible to update the task',
                'errors' => $taskModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $taskModel = new TaskModel();

        if (!$taskModel->find($id)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => "Task not found - TaskController delete function"
            ]);
        }

        $taskModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => "Task deleted successfully"
        ]);
    }
}
