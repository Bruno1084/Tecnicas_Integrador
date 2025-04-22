<?php

namespace App\Types;

class Usuario
{
    private $id = 0;
    private $name = "";
    private $nickname = "";
    private $email = "";
    private $password = "";

    public function __construct($id, $name, $nickname, $email, $password)
    {
        $this->$id = $id;
        $this->$name = $name;
        $this->$nickname = $nickname;
        $this->$email = $email;
        $this->$password = $password;
    }
};
