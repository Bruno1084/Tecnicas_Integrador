<?php

namespace App\Models;

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
        'idAutor'
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

    /**
     * Devuelve todas las tareas activas.
     * Si no tenés un campo "active", podés eliminar este método o adaptarlo.
     */
    public function getAllActive()
    {
        return $this->where('active', 1)->findAll(); // Solo si tenés el campo 'active'
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
