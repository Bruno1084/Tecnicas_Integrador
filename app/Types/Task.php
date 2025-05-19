<?php

namespace App\Types;

use DateTime;

class Task
{
    private int $id = 0;
    private string $subject = "";
    private string $description = "";
    private string $priority = "";
    private string $state = "";
    private DateTime $expirationDate;
    private ?DateTime $reminderDate = null;
    private int $idAutor = 0;

    public function __construct($id, $subject, $description, $priority, $state, $expirationDate, $reminderDate = null, $idAutor)
    {
        $this->setId($id);
        $this->setSubject($subject);
        $this->setDescription($description);
        $this->setPriority($priority);
        $this->setState($state);
        $this->setExpirationDate($expirationDate);
        $this->setReminderDate($reminderDate);
        $this->setIdAutor($idAutor);

        $this->checkVars();
    }

    public function checkVars()
    {
        if (is_string($this->id)) {
            throw new \InvalidArgumentException("El id no puede ser un string");
        }

        if (is_string($this->idAutor)) {
            throw new \InvalidArgumentException("El idAutor no puede ser un string");
        }

        if (is_numeric($this->subject)) {
            throw new \InvalidArgumentException("El asunto no puede ser un número.");
        }

        $estadosValidos = ['no iniciada', 'en proceso', 'completada'];
        if (!in_array(strtolower($this->state), $estadosValidos)) {
            throw new \InvalidArgumentException("Estado inválido. Debe ser: no iniciada, en proceso o completada.");
        }

        $hoy = new \DateTime();
        if ($this->expirationDate < $hoy) {
            throw new \InvalidArgumentException("La fecha de vencimiento no puede estar en el pasado.");
        }

        if ($this->reminderDate !== null && $this->reminderDate > $this->expirationDate) {
            throw new \InvalidArgumentException("La fecha de recordatorio debe ser anterior a la fecha de vencimiento.");
        }
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getExpirationDate(): ?DateTime
    {
        return $this->expirationDate;
    }

    public function getReminderDate(): ?DateTime
    {
        return $this->reminderDate;
    }

    public function getIdAutor(): int
    {
        return $this->idAutor;
    }

    // Setters
    public function setId(int $id): void
    {
        if (is_string($id)) {
            throw new \InvalidArgumentException("El id no puede ser un string");
        }
        $this->id = $id;
    }

    public function setSubject(string $subject): void
    {
        if (is_numeric($subject)) {
            throw new \InvalidArgumentException("El asunto no puede ser un número.");
        }
        $this->subject = $subject;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

    public function setState(string $state): void
    {
        $estadosValidos = ['no iniciada', 'en proceso', 'completada'];
        if (!in_array(strtolower($state), $estadosValidos)) {
            throw new \InvalidArgumentException("Estado inválido. Debe ser: no iniciada, en proceso o completada.");
        }
        $this->state = $state;
    }

    public function setExpirationDate(DateTime $fecha): void
    {
        $this->expirationDate = $fecha instanceof DateTime ? $fecha : new DateTime($fecha);
    }

    public function setReminderDate(?DateTime $fecha): void
    {
        if (is_null($fecha)) {
            $this->reminderDate = null;
        } else {
            $this->reminderDate = $fecha instanceof DateTime ? $fecha : new DateTime($fecha);
        }
    }

    public function setIdAutor(int $idAutor): void
    {
        if (is_string($idAutor)) {
            throw new \InvalidArgumentException("El idAutor no puede ser un string");
        }
        $this->idAutor = $idAutor;
    }
}
