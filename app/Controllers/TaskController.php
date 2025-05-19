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
    // Get Routes
    public function getAll()
    {
        $session = session();
        $userId = $session->get('userId');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $filters = [
            'userId' => $userId,
            'subject' => $this->request->getGet('subject'),
            'priority' => $this->request->getGet('priority'),
            'expirationDate' => $this->request->getGet('expirationDate'),
            'state' => $this->request->getGet('state'),
            'excludeSharedByUser' => true,
            'active' => true,
        ];

        $data['tasks'] = $this->getFiltered($filters);
        $data['userNickname'] = $user['nickname'];

        return view('tasks/index', $data);
    }

    public function getOne($id)
    {
        $taskModel = new TaskModel();
        $session = session();

        $data = [
            'task' => $taskModel->getTask($id),
            'subtasks' => $taskModel->getAllSubtasksFromTask($id),
        ];

        return view('/tasks/ver_tarea', $data);
    }

    public function getFiltered($filters = [])
    {
        $taskModel = new TaskModel();

        if (!isset($filters['userId'])) {
            return [];
        }

        $taskModel->where('idAutor', $filters['userId']);

        // Filtrado por tareas activas/inactivas
        if (!isset($filters['active']) || $filters['active'] === true) {
            $taskModel->where('active', 1);
        } else {
            $taskModel->where('active', 0);
        }

        // Excluir tareas compartidas por el usuario
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

        // Filtros adicionales
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


    // Create Routes
    public function getCreate()
    {
        return view('/tasks/crear_tarea');
    }

    public function postCreate()
    {
        $session = session();
        $idAutor = $session->get('userId');

        $taskModel = new TaskModel();

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
                $idAutor,
            );
        } catch (InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'subject' => $task->getSubject(),
            'description' => $task->getDescription(),
            'priority' => $task->getPriority(),
            'state' => $task->getState(),
            'expirationDate' => $task->getExpirationDate()->format('Y-m-d'),
            'reminderDate' => $task->getReminderDate()?->format('Y-m-d'),
            'idAutor' => $task->getIdAutor(),
        ];

        $newTaskId = $taskModel->insert($data);
        if (!$newTaskId) {
            return redirect()->back()->withInput()->with('errors', $taskModel->errors());
        }

        return redirect()->to('/tasks/' . $newTaskId)->with('message', 'Subtarea creada con éxito');
    }


    // Edit Routes
    public function getEdit() {}

    public function postEdit($idTask) {}



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

        // 1. Tareas compartidas CON el usuario (colaborador)
        $sharedTaskIdsByUser = $taskCollaboratorModel
            ->where('idUser', $userId)
            ->select('idTask')
            ->findColumn('idTask');

        // 2. Tareas creadas por el usuario que tienen colaboradores
        $sharedTaskIdsByAuthor = $taskCollaboratorModel
            ->select('idTask')
            ->join('tasks', 'tasks.id = task_collaborators.idTask')
            ->where('tasks.idAutor', $userId)
            ->groupBy('idTask')
            ->findColumn('idTask');

        // Combinar IDs sin duplicados
        $allSharedTaskIds = array_unique(array_merge($sharedTaskIdsByUser, $sharedTaskIdsByAuthor));

        if (empty($allSharedTaskIds)) {
            return view('/Tasks/shared_tasks', [
                'sharedTasks' => [],
                'userNickname' => 'Colaborador'
            ]);
        }

        // Obtener tareas con nickname del autor
        $sharedTasks = $taskModel
            ->select('tasks.*, users.nickname as authorNickname')
            ->join('users', 'tasks.idAutor = users.id')
            ->whereIn('tasks.id', $allSharedTaskIds)
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
            'priority' => $task->getPriority(),
            'state' => $task->getState(),
            'expirationDate' => $task->getExpirationDate()->format('Y-m-d'),
            'reminderDate' => $task->getReminderDate()?->format('Y-m-d'),
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
            'expirationDate' => $task->getExpirationDate()->format('Y-m-d'),
            'reminderDate' => $task->getReminderDate()?->format('Y-m-d'),
            'idAutor' => $task->getIdAutor(),
        ];

        if (!$taskModel->update($task->getId(), $data)) {
            return redirect()->back()->withInput()->with('errors', $taskModel->errors());
        }

        return redirect()->to('/tasks')->with('message', 'Tarea creada con éxito');
    }

    public function delete($id)
    {
        $taskModel = new TaskModel();
        $session = session();
        $userId = $session->get('userId');

        $task = $taskModel->find($id);

        if (!$task) {
            return redirect()->back()->with('error', 'Tarea no encontrada.');
        }

        if ($task['idAutor'] != $userId) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar esta tarea.');
        }

        $taskModel->update($id, ['active' => 0]);

        return redirect()->to('/tasks')->with('message', 'Tarea eliminada con éxito.');
    }
}
