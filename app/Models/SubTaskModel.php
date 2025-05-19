<?php

namespace App\Models;

use CodeIgniter\Model;

class SubTaskModel extends Model
{
    protected $table = 'subtasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'subject',
        'description',
        'priority',
        'state',
        'reminderDate',
        'expirationDate',
        'comment',
        'idResponsible',
        'idTask'
    ];


    /* Obtiene una subtarea por ID, incluyendo datos del responsable si tiene */
    public function getSubtask($id)
    {
        return $this->db->table('subtasks st')
            ->select('st.*, u.name as responsibleName, u.nickname as responsibleNickname, u.email as responsibleEmail')
            ->join('users u', 'st.idResponsible = u.id', 'left')
            ->where('st.id', $id)
            ->get()
            ->getRowArray();
    }

    /* Obtiene todas las subtareas de una tarea */
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
