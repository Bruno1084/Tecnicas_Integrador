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

        $taskModel = new TaskModel();
        $tasks = $taskModel->getAllActive($userId);

        $filters = [
            'userId' => $userId,
            'subject' => $this->request->getGet('subject'),
            'priority' => $this->request->getGet('priority'),
            'expirationDate' => $this->request->getGet('expirationDate'),
            'state' => $this->request->getGet('state'),
            'active' => true,
        ];

        $data['tasks'] = $this->getFiltered($tasks, $filters);

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

    public function getFiltered($tasks, $filters = [])
    {
        if (!isset($filters['userId'])) {
            return [];
        }

        return array_values(array_filter($tasks, function ($task) use ($filters) {
            // Solo tareas del autor
            if ($task['idAutor'] != $filters['userId']) {
                return false;
            }

            // Filtrado por estado activo/inactivo
            if (isset($filters['active'])) {
                $isActive = $filters['active'] ? 1 : 0;
                if ($task['active'] != $isActive) {
                    return false;
                }
            }

            // Filtro por asunto
            if (!empty($filters['subject']) && stripos($task['subject'], $filters['subject']) === false) {
                return false;
            }

            // Filtro por prioridad
            if (!empty($filters['priority']) && $task['priority'] != $filters['priority']) {
                return false;
            }

            // Filtro por estado
            if (!empty($filters['state']) && $task['state'] != $filters['state']) {
                return false;
            }

            // Filtro por fecha de vencimiento
            if (!empty($filters['expirationDate']) && $task['expirationDate'] != $filters['expirationDate']) {
                return false;
            }

            return true;
        }));
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
    public function getUpdate($idTask)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($idTask);
        $data = [
            'task' => $task
        ];

        return view('/tasks/editar_tarea', $data);
    }

    public function postUpdate($idTask)
    {
        $taskModel = new TaskModel();
        $oldTask = $taskModel->find($idTask);

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
                $oldTask['idAutor']
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
            'idAutor' => $oldTask['idAutor'],
        ];

        if (!$taskModel->update($idTask, $data)) {
            return redirect()->back()->withInput()->with('errors', $taskModel->errors());
        }

        return redirect()->to('/tasks/' . $idTask)->with('message', 'Tarea editada con éxito');
    }


    // Delete Routes
    public function getDelete($idTask)
    {
        $taskModel = new TaskModel();
        $taskModel->delete($idTask);

        return redirect()->to('/tasks');
    }


    // Share Routes
    public function getShare()
    {
        $session = session();
        $idUser = $session->get('userId');
        $taskModel = new TaskModel();
        $data = [
            'tasks' => $taskModel->getAllActive($idUser),

        ];

        return view('/tasks/compartir_tarea', $data);
    }

    public function postShare()
    {
        $userModel = new UserModel();
        $taskCollaboratorModel = new TaskCollaboratorModel();

        // User email is unique in the database.
        $user = $userModel->where('email', $this->request->getPost('userEmail'))->first();

        $data = [
            'idUser' => $user['id'],
            'idTask' => $this->request->getPost('idTask'),
        ];

        $newTaskCollaboratorId = $taskCollaboratorModel->insert($data);
        if (!$newTaskCollaboratorId) {
            return redirect()->back()->withInput()->with('errors', $taskCollaboratorModel->errors());
        }

        return redirect()->to('/tasks/' . $this->request->getPost('idTask'))->with('message', 'Tarea compartida con éxito.');
    }


    // Shared Tasks Routes
    public function getSharedTasks()
    {
        $session = session();
        $idUser = $session->get('userId');

        $taskModel = new TaskModel();
        $data = [
            'sharedTasks' => $taskModel->getTasksByParticipant($idUser),
        ];

        return view('/tasks/tareas_compartidas', $data);


    }
}
