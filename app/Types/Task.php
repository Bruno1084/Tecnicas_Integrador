<?php

namespace App\Types;

class Task
{
    private $id = 0;
    private $subject = "";
    private $description = "";
    private $state = "";
    private $expirationDate;
    private $reminderDate;
    private $color = "";
    private $idAutor = 0;

    function __construct($id, $subject, $description, $state, $expirationDate, $reminderDate, $color, $idAutor)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->description = $description;
        $this->state = $state;
        $this->expirationDate = $expirationDate;
        $this->reminderDate = $reminderDate;
        $this->color = $color;
        $this->idAutor = $idAutor;
    }
}
