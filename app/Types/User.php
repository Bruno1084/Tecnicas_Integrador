<?php

namespace App\Types;

use InvalidArgumentException;

class User
{
    private int $id = 0;
    private string $name = "";
    private string $nickname = "";
    private string $email = "";
    private string $password = "";

    public function __construct(int $id, string $name, string $nickname, string $email, string $password)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setNickname($nickname);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(int $id): void
    {
        if ($id < 0) {
            throw new InvalidArgumentException("El ID no puede ser negativo.");
        }
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        if (trim($name) === '') {
            throw new InvalidArgumentException("El nombre no puede estar vacío.");
        }
        $this->name = $name;
    }

    public function setNickname(string $nickname): void
    {
        if (trim($nickname) === '') {
            throw new InvalidArgumentException("El nickname no puede estar vacío.");
        }
        $this->nickname = $nickname;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El email no es válido.");
        }
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        if (empty($password)) {
            throw new InvalidArgumentException("La contraseña no puede estar vacía.");
        }
        $this->password = $password;
    }
}
