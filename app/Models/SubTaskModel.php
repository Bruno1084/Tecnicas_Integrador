<?php

namespace App\Models;

use CodeIgniter\Model;

class SubTaskModel extends Model
{
    protected $table = 'subtasks';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'description',
        'priority',
        'state',
        'expirationDate',
        'comment',
        'idResponsible',
        'idTask'
    ];
}
