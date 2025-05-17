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
    public function newSubTask($idTask)
    {
        $data = [
            'idTask' => $idTask
        ];

        return view('/SubTasks/new_subtask', $data);
    }

    public function getAll($idTask)
    {
        $subTaskModel = new SubTaskModel();
        $taskModel = new TaskModel();

        // Obtener la tarea completa con el autor (nickname del autor)
        $data['task'] = $taskModel
            ->select('tasks.*, users.nickname as authorNickname')
            ->join('users', 'users.id = tasks.idAutor')
            ->where('tasks.id', $idTask)
            ->first();

        $builder = $subTaskModel->builder();

        // Obtener subtasks con nickname del responsable
        $subTasks = $builder
            ->select('subtasks.*, users.nickname as responsibleNickname')
            ->join('users', 'users.id = subtasks.idResponsible', 'left') // left join por si no hay responsable asignado
            ->where('subtasks.idTask', $idTask)
            ->get()
            ->getResultArray();

        $data['subTasks'] = $subTasks;

        $session = session();
        $userModel = new UserModel();
        $data['loggedUser'] = $userModel->where('id', $session->get('userId'))->first();

        return view('/SubTasks/index', $data);
    }

    public function getOne($idSubTask)
    {
        $subTaskModel = new SubTaskModel();
        $data['subtask'] = $subTaskModel->where('id', $idSubTask)->first();

        return view('/SubTasks/subtask', $data);
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
