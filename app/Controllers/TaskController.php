<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\UserModel;

class TaskController extends BaseController
{
    public function completedTasks() {
        $session = session();
        $userId = $session->get('userId');

        $filters = [
            'userId' => $userId,
            'state' => $this->request->getGet('state')
        ];

        $data['completedTasks'] = $this->getFiltered($filters);

        return view('Tasks/completed_tasks');
    }

    public function getAll()
    {
        $session = session();
        $userId = $session->get('userId');

        $userModel = new UserModel();
        $user = $userModel->where('id', $userId)->first();

        $filters = [
            'userId' => $userId,
            'subject' => $this->request->getGet('subject'),
            'priority' => $this->request->getGet('priority'),
            'expirationDate' => $this->request->getGet('expirationDate'),
        ];

        $data['tasks'] = $this->getFiltered($filters);
        $data['userNickname'] = $user['nickname'];

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

    public function getFiltered($filters = [])
    {
        $taskModel = new TaskModel();

        $taskModel->where('idAutor', $filters['userId']);

        if (!empty($filters['subject'])) {
            $taskModel->like('subject', $filters['subject']);
        } elseif (!empty($filters['state'])) {
            $taskModel->where('state', $filters['state']);
        } elseif (!empty($filters['priority'])) {
            $taskModel->where('priority', $filters['priority']);
        } elseif (!empty($filters['expirationDate'])) {
            $taskModel->where('expirationDate', $filters['expirationDate']);
        }

        return $taskModel->findAll();
    }

    public function newTask()
    {
        return view('Tasks/new_task');
    }

    public function create()
    {
        $taskModel = new TaskModel();
        $session = session();

        $idAutor = $session->get('userId');

        $data = [
            'subject' => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'state' => $this->request->getPost('state'),
            'reminderDate' => $this->request->getPost('reminderDate'),
            'expitarionDate' => $this->request->getPost('expirationDate'),
            'color' => $this->request->getPost('color'),
            'idAutor' => $idAutor,
        ];

        if (!$taskModel->insert($data)) {
            print_r($taskModel->errors());
        } else {
            return redirect()->to('/tasks');
        }
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
