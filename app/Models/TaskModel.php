<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'subject',
        'description',
        'priority',
        'state',
        'reminderDate',
        'expirationDate',
        'idAutor',
        'active'
    ];

    /* Obtiene una tarea por ID, incluyendo datos del autor. */
    public function getTask($idTask)
    {
        return $this->db->table('tasks t')
            ->select('t.*, u.name as authorName, u.nickname as authorNickname, u.email as authorEmail')
            ->join('users u', 't.idAutor = u.id', 'left')
            ->where('t.id', $idTask)
            ->get()
            ->getRowArray();
    }

    /* Retorna todas las tareas donde el usuario es autor. */
    public function getAllActive($idAutor)
    {
        return $this->db->table('tasks t')
            ->select('t.*, u.nickname as authorNickname')
            ->join('users u', 't.idAutor = u.id', 'left')
            ->where('u.id', $idAutor)
            ->where('t.active', true)
            ->get()
            ->getResultArray();
    }

    /* Retorna todas las tareas donde el usuario es asignado como colaborador. */
    public function getTasksByParticipant($idUser)
    {
        return $this->db->table('tasks t')
            ->select('t.*, u.nickname as authorNickname, tc.canEdit')
            ->join('users u', 't.idAutor = u.id', 'left')
            ->join('task_collaborators tc', 'tc.idTask = t.id')
            ->where('tc.idUser', $idUser)
            ->where('t.idAutor !=', $idUser)
            ->where('t.active', true)
            ->get()
            ->getResultArray();
    }

    /* Retorna todas las subtareas de una tarea específica. */
    public function getAllSubtasksFromTask(int $idTask)
    {
        return $this->db->table('subtasks st')
            ->select('st.*, u.name as responsibleName, u.nickname as responsibleNickname, u.email as responsibleEmail')
            ->join('users u', 'st.idResponsible = u.id', 'left')
            ->where('st.idTask', $idTask)
            ->orderBy('st.expirationDate', 'ASC')
            ->get()
            ->getResultArray();
    }
}
