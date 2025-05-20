<?php

namespace App\Types;

use DateTime;
use InvalidArgumentException;

class SubTask
{
    private int $id;
    private string $subject;
    private string $description;
    private string $priority;
    private string $state;
    private DateTime $expirationDate;
    private ?DateTime $reminderDate;
    private string $comment;
    private int $idResponsible;
    private int $idTask;

    public function __construct(
        int $id,
        string $subject,
        string $description,
        string $priority,
        string $state,
        DateTime $expirationDate,
        ?DateTime $reminderDate,
        string $comment,
        int $idResponsible,
        int $idTask
    ) {
        $this->setId($id);
        $this->setSubject($subject);
        $this->setDescription($description);
        $this->setPriority($priority);
        $this->setState($state);
        $this->setExpirationDate($expirationDate);
        $this->setReminderDate($reminderDate);
        $this->setComment($comment);
        $this->setIdResponsible($idResponsible);
        $this->setIdTask($idTask);
    }

    // --- Setters con validaciones ---
    public function setId(int $id): void
    {
        if ($id < 0) {
            throw new InvalidArgumentException("ID inválido");
        }
        $this->id = $id;
    }

    public function setSubject(string $subject): void
    {
        if (empty($subject)) {
            throw new InvalidArgumentException("El asunto no puede estar vacío");
        }
        $this->subject = $subject;
    }

    public function setDescription(string $description): void
    {
        if (empty($description)) {
            throw new InvalidArgumentException("La descripción no puede estar vacía");
        }
        $this->description = $description;
    }

    public function setPriority(string $priority): void
    {
        $allowed = ['alta', 'media', 'baja'];
        if (!in_array($priority, $allowed)) {
            throw new InvalidArgumentException("Prioridad inválida");
        }
        $this->priority = $priority;
    }

    public function setState(string $state): void
    {
        $allowed = ['no iniciada', 'en proceso', 'completada'];
        if (!in_array($state, $allowed)) {
            throw new InvalidArgumentException("Estado inválido");
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

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function setIdResponsible(int $idResponsible): void
    {
        if ($idResponsible < 0) {
            throw new InvalidArgumentException("IdResponsible inválido");
        }
        $this->idResponsible = $idResponsible;
    }

    public function setIdTask(int $idTask): void
    {
        if ($idTask < 0) {
            throw new InvalidArgumentException("IdTask inválido");
        }
        $this->idTask = $idTask;
    }

    // --- Getters ---
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

    public function getExpirationDate(): DateTime
    {
        return $this->expirationDate;
    }

    public function getReminderDate(): ?DateTime
    {
        return $this->reminderDate;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getIdResponsible(): int
    {
        return $this->idResponsible;
    }

    public function getIdTask(): int
    {
        return $this->idTask;
    }
}
