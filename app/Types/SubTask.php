<?php

namespace App\Types;

class SubTask
{
    private $id = 0;
    private $description = "";
    private $priority = "";
    private $state = "";
    private $expirationDate;
    private $reminderDate;

    function __construct($id, $description, $priority, $state, $expirationDate, $reminderDate)
    {
        $this->id = $id;
        $this->description = $description;
        $this->priority = $priority;
        $this->state = $state;
        $this->expirationDate = $expirationDate;
        $this->reminderDate = $reminderDate;
    }
};
