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
        $subtask = $subTaskModel->getSubtask($idSubTask);
        $data = [
            'subtask' => $subtask
        ];

        return view('/subtasks/editar_subtarea', $data);
    }

    public function postUpdate($idSubTask)
    {
        $subTaskModel = new SubTaskModel();
        $oldSubtask = $subTaskModel->find($idSubTask);

        // Pasar fechas del formulario a Datetime
        $expirationDate = new DateTime($this->request->getPost('expirationDate'));
        $reminderDate = $this->request->getPost('reminderDate')
            ? new DateTime($this->request->getPost('reminderDate'))
            : null;

        try {
            $subtask = new SubTask(
                $idSubTask,
                $this->request->getPost('subject'),
                $this->request->getPost('description'),
                $this->request->getPost('priority'),
                $this->request->getPost('state'),
                $expirationDate,
                $reminderDate,
                $this->request->getPost('comment'),
                $oldSubtask['idResponsible'],
                $oldSubtask['idTask']
            );
        } catch (InvalidArgumentException $e) {
            // Hay un error con los inputs. Devolver errores de Type Task
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'subject' => $subtask->getSubject(),
            'description' => $subtask->getDescription(),
            'priority' => $subtask->getPriority(),
            'state' => $subtask->getState(),
            'expirationDate' => $subtask->getExpirationDate()->format('Y-m-d'),
            'reminderDate' => $subtask->getReminderDate()?->format('Y-m-d'),
            'comment' => $subtask->getComment(),
            'idResponsible' => $oldSubtask['idResponsible'],
            'idTask' => $oldSubtask['idTask'],
        ];

        if (!$subTaskModel->update($idSubTask, $data)) {
            return redirect()->back()->withInput()->with('errors', $subTaskModel->errors());
        }

        return redirect()->to('/subtasks/' . $oldSubtask['id'])->with('message', 'Subtarea editada con éxito');
    }

    // Delete
    public function getDelete($idSubTask)
    {
        $subTaskModel = new SubTaskModel();
        $subTaskModel->delete($idSubTask);

        return view('/tasks/index');
    }
}
