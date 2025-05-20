<?php

namespace App\Controllers;

use App\Models\SubTaskModel;
use App\Models\TaskModel;
use App\Types\SubTask;
use DateTime;
use InvalidArgumentException;

class SubTaskController extends BaseController
{
    // Get Routes
    public function getOne($id)
    {
        $subTaskModel = new SubTaskModel();
        $data = [
            'subtask' => $subTaskModel->getSubtask($id),
        ];

        return view('subtasks/ver_subtarea', $data);
    }

    // Create Routes
    public function getCreate($idTask)
    {
        $data = [
            'idTask' => $idTask
        ];

        return view('subtasks/crear_subtarea', $data);
    }

    public function postCreate()
    {
        $session = session();
        $idAutor = $session->get('userId');

        $subTaskModel = new SubTaskModel();

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
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
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

        $newSubtaskId = $subTaskModel->insert($data);
        if (!$newSubtaskId) {
            return redirect()->back()->withInput()->with('errors', $subTaskModel->errors());
        }

        return redirect()->to('/subtasks/' . $newSubtaskId)->with('message', 'Subtarea creada con éxito');
    }

    // Edit Routes
    public function getUpdate($idSubTask)
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

    public function postUpdate($idSubTask) {}

    // Delete
    public function getDelete($idSubTask)
    {
        $taskModel = new TaskModel();
        $taskModel->delete($idSubTask);

        return view('/tasks');
    }
}
