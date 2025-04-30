<?php

namespace App\Models;

use CodeIgniter\Model;

class SubTaskModel extends Model
{
    protected $table = 'subtasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'description',
        'priority',
        'state',
        'reminderDate',
        'comment',
        'idResponsible',
    ];
}
