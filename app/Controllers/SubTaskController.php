<?php

namespace App\Controllers;

use App\Models\SubTaskModel;
use App\Models\TaskCollaboratorModel;
use App\Models\TaskModel;
use App\Models\UserModel;
use App\Types\SubTask;
use DateTime;
use InvalidArgumentException;

class SubTaskController extends BaseController
{
    public function getAll($idTask)
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

        return view('Tasks/index', $data);
    }

    public function getOne($id)
    {
        $subTaskModel = new SubTaskModel();
        $data = [
            'subtask' => $subTaskModel->getSubtask($id),
        ];

        return view('subtasks/ver_subtarea', $data);
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

    public function newSubTask($idTask)
    {
        $data = [
            'idTask' => $idTask
        ];

        return view('/SubTasks/new_subtask', $data);
    }

    public function create()
    {
        $subTaskModel = new SubTaskModel();
        $session = session();
        $idAutor = $session->get('userId');

        // Pasar fechas del formulario a Datetime
        $expirationDate = new DateTime($this->request->getPost('expirationDate'));
        $reminderDate = $this->request->getPost('reminderDate')
            ? new DateTime($this->request->getPost('reminderDate'))
            : null;

        try {
            $subTask = new SubTask(
                0,
                $this->request->getPost('subject'),
                $this->request->getPost('description'),
                $this->request->getPost('priority'),
                'no iniciada',
                $expirationDate,
                $reminderDate,
                $this->request->getPost('comment'),
                $idAutor,
                $this->request->getPost('idTask')
            );
        } catch (InvalidArgumentException $e) {
            // Hay un error con los inputs. Devolver errores de Type Task
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'id' => $subTask->getId(),
            'subject' => $subTask->getSubject(),
            'description' => $subTask->getDescription(),
            'priority' => $subTask->getPriority(),
            'state' => $subTask->getState(),
            'expirationDate' => $subTask->getExpirationDate()->format('Y-m-d'),
            'reminderDate' => $subTask->getReminderDate()?->format('Y-m-d'),
            'comment' => $subTask->getComment(),
            'idResponsible' => $subTask->getIdResponsible(),
            'idTask' => $subTask->getIdTask(),
        ];

        if (!$subTaskModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $subTaskModel->errors());
        }

        return redirect()->to('/tasks/' . $subTask->getIdTask() . '/subtasks')->with('message', 'Subtarea creada con éxito');
    }

    public function update($idSubTask)
    {
        $subTaskModel = new SubTaskModel();
        $taskModel = new TaskModel();
        $session = session();
        $idAutor = $session->get('userId');

        // Pasar fechas del formulario a Datetime
        $expirationDate = new DateTime($this->request->getPost('expirationDate'));
        $reminderDate = $this->request->getPost('reminderDate')
            ? new DateTime($this->request->getPost('reminderDate'))
            : null;

        try {
            $subTask = new SubTask(
                $idSubTask,
                $this->request->getPost('subject'),
                $this->request->getPost('description'),
                $this->request->getPost('priority'),
                $this->request->getPost('state'),
                $expirationDate,
                $reminderDate,
                $this->request->getPost('comment'),
                $idAutor,
                $this->request->getPost('idTask')
            );
        } catch (InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'id' => $subTask->getId(),
            'subject' => $subTask->getSubject(),
            'description' => $subTask->getDescription(),
            'priority' => $subTask->getPriority(),
            'state' => $subTask->getState(),
            'expirationDate' => $subTask->getExpirationDate()->format('Y-m-d'),
            'reminderDate' => $subTask->getReminderDate()?->format('Y-m-d'),
            'comment' => $subTask->getComment(),
            'idResponsible' => $subTask->getIdResponsible(),
            'idTask' => $subTask->getIdTask(),
        ];

        if (!$subTaskModel->update($subTask->getId(), $data)) {
            return redirect()->back()->withInput()->with('errors', $subTaskModel->errors());
        }

        // Verificar el estado de las subtareas para actualizar la tarea
        $taskId = $subTask->getIdTask();
        $allCompleted = $subTaskModel
            ->where('idTask', $taskId)
            ->where('state !=', 'completada')
            ->countAllResults() === 0;

        if ($allCompleted) {
            $taskModel->update($taskId, ['state' => 'completada']);
        } else {
            $task = $taskModel->find($taskId);
            if ($task['state'] === 'no iniciada' && in_array($subTask->getState(), ['en proceso', 'completada'])) {
                $taskModel->update($taskId, ['state' => 'en proceso']);
            }
        }

        return redirect()->to('tasks/' . $taskId . '/subtasks')->with('message', 'Subtarea actualizada con éxito');
    }
}
