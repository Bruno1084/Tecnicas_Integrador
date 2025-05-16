<?php

namespace App\Controllers;

use App\Models\SubTaskModel;
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

        $subTaskModel = new SubTaskModel();
        $taskModel = new TaskModel();
        $userModel = new UserModel();

        $data['task'] = $taskModel->find($idTask);
        $data['subTasks'] = $subTaskModel->where('idTask', $idTask)->findAll();
        $data['responsible'] = $userModel->where('id', $session->get('userId'))->first();
        return view('/SubTasks/index', $data);
    }

    public function getOne($idSubTask) {
        $subTaskModel = new SubTaskModel();
        $data['subtask'] = $subTaskModel->where('id', $idSubTask)->first();

        return view('/SubTasks/subtask', $data);
    }

    public function update($idSubTask)
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

        return redirect()->to('/tasks/' . $subTask->getId() . '/subtasks')->with('message', 'Subtarea creada con éxito');
    }
}
