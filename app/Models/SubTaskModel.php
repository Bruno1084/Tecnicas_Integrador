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
}
