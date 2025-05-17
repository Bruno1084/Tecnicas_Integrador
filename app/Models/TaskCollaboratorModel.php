<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskCollaboratorModel extends Model
{
    protected $table = 'task_collaborators';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'idTask',
        'idUser',
        'canEdit'
    ];

    // Obtener todos los colaboradores de una tarea
    public function getCollaboratorsByTask($taskId)
    {
        return $this->where('idTask', $taskId)->findAll();
    }

    // Verifica si un usuario tiene permisos para editar una tarea
    public function userCanEdit($taskId, $userId): bool
    {
        return $this->where(['idTask' => $taskId, 'idUser' => $userId, 'canEdit' => true])->countAllResults() > 0;
    }

    // Verifica si un usuario es colaborador (aunque sea solo lectura)
    public function isCollaborator($taskId, $userId): bool
    {
        return $this->where(['idTask' => $taskId, 'idUser' => $userId])->countAllResults() > 0;
    }
}
