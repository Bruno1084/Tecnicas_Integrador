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
        'idAutor',
        'active'
    ];

    public function getAllActive()
    {
        return $this->where('active', 1)->findAll();
    }
}
