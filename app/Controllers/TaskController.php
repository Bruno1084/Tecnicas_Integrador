<?php

namespace App\Controllers;

use App\Models\TaskCollaboratorModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use App\Types\Task;
use DateTime;
use InvalidArgumentException;

class TaskController extends BaseController
{
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
            'state' => $this->request->getGet('state'),
            'excludeSharedByUser' => true,
        ];

        $data['tasks'] = $this->getFiltered($filters);
        $data['userNickname'] = $user['nickname'];

        return view('Tasks/index', $data);
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

        if (!isset($filters['userId'])) {
            return [];
        }

        $taskModel->where('idAutor', $filters['userId']);

        if (!empty($filters['excludeSharedByUser'])) {
            $taskCollaboratorModel = new TaskCollaboratorModel();
            $sharedTaskIdsByUser = $taskCollaboratorModel
                ->select('idTask')
                ->join('tasks', 'tasks.id = task_collaborators.idTask')
                ->where('tasks.idAutor', $filters['userId'])
                ->findColumn('idTask');

            if (!empty($sharedTaskIdsByUser)) {
                $taskModel->whereNotIn('id', $sharedTaskIdsByUser);
            }
        }


        if (!empty($filters['subject'])) {
            $taskModel->like('subject', $filters['subject']);
        }

        if (!empty($filters['priority'])) {
            $taskModel->where('priority', $filters['priority']);
        }

        if (!empty($filters['state'])) {
            $taskModel->where('state', $filters['state']);
        }

        if (!empty($filters['expirationDate'])) {
            $taskModel->where('expirationDate', $filters['expirationDate']);
        }

        return $taskModel->findAll();
    }

    public function newTask()
    {
        return view('Tasks/new_task');
    }

    public function shareTask($idTask)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($idTask);

        if (!$task) {
            return redirect()->to('/tasks')->with('error', 'Tarea no encontrada.');
        }

        return view('/Tasks/share_task', ['task' => $task]);
    }

public function sharedTasks()
{
    $session = session();
    $userId = $session->get('userId');

    $taskCollaboratorModel = new TaskCollaboratorModel();
    $taskModel = new TaskModel();

    // Obtener IDs de tareas compartidas con el usuario
    $sharedTaskIds = $taskCollaboratorModel
        ->where('idUser', $userId)
        ->select('idTask')
        ->findColumn('idTask');

    if (empty($sharedTaskIds)) {
        return view('/Tasks/shared_tasks', [
            'sharedTasks' => [],
            'userNickname' => 'Colaborador'
        ]);
    }

    // Obtener tareas con nickname del autor
    $sharedTasks = $taskModel
        ->select('tasks.*, users.nickname as authorNickname')
        ->join('users', 'tasks.idAutor = users.id')
        ->whereIn('tasks.id', $sharedTaskIds)
        ->asArray()
        ->findAll();

    return view('/Tasks/shared_tasks', [
        'sharedTasks' => $sharedTasks,
        'userNickname' => 'Colaborador'
    ]);
}





    public function addShareTask($idTask)
    {
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $taskCollaboratorModel = new TaskCollaboratorModel();

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'No se encontró un usuario con ese correo.');
        }

        // Verificar si ya es colaborador
        $exists = $taskCollaboratorModel
            ->where('idTask', $idTask)
            ->where('idUser', $user['id'])
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Este usuario ya es colaborador de la tarea.');
        }

        // Insertar colaboración
        $taskCollaboratorModel->insert([
            'idTask' => $idTask,
            'idUser' => $user['id'],
        ]);

        return redirect()->back()->with('message', 'Tarea compartida con éxito.');
    }

    public function create()
    {
        $taskModel = new TaskModel();
        $session = session();
        $idAutor = $session->get('userId');

        // Pasar fechas del formulario a Datetime
        $expirationDate = new DateTime($this->request->getPost('expirationDate'));
        $reminderDate = $this->request->getPost('reminderDate')
            ? new DateTime($this->request->getPost('reminderDate'))
            : null;

        try {
            $task = new Task(
                0,
                $this->request->getPost('subject'),
                $this->request->getPost('description'),
                $this->request->getPost('priority'),
                'no iniciada',
                $expirationDate,
                $reminderDate,
                $idAutor
            );
        } catch (InvalidArgumentException $e) {
            // Hay un error con los inputs. Devolver errores de Type Task
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'subject' => $task->getSubject(),
            'description' => $task->getDescription(),
            'state' => $task->getState(),
            'reminderDate' => $task->getReminderDate()?->format('Y-m-d'),
            'expirationDate' => $task->getExpirationDate()->format('Y-m-d'),
            'idAutor' => $task->getIdAutor(),
        ];

        if (!$taskModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $taskModel->errors());
        }

        return redirect()->to('/tasks')->with('message', 'Tarea creada con éxito');
    }

    public function update($idTask)
    {
        $taskModel = new TaskModel();
        $session = session();
        $idAutor = $session->get('userId');


        // Pasar fechas del formulario a Datetime
        $expirationDate = new DateTime($this->request->getPost('expirationDate'));
        $reminderDate = $this->request->getPost('reminderDate')
            ? new DateTime($this->request->getPost('reminderDate'))
            : null;

        try {
            $task = new Task(
                $idTask,
                $this->request->getPost('subject'),
                $this->request->getPost('description'),
                $this->request->getPost('priority'),
                $this->request->getPost('state'),
                $expirationDate,
                $reminderDate,
                $idAutor
            );
        } catch (InvalidArgumentException $e) {
            // Hay un error con los inputs. Devolver errores de Type Task
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'subject' => $task->getSubject(),
            'description' => $task->getDescription(),
            'priority' => $task->getPriority(),
            'state' => $task->getState(),
            'reminderDate' => $task->getReminderDate()?->format('Y-m-d'),
            'expirationDate' => $task->getExpirationDate()->format('Y-m-d'),
            'idAutor' => $task->getIdAutor(),
        ];

        if (!$taskModel->update($task->getId(), $data)) {
            return redirect()->back()->withInput()->with('errors', $taskModel->errors());
        }

        return redirect()->to('/tasks')->with('message', 'Tarea creada con éxito');
    }

    public function delete($id) {}
}
