<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="integer")
     */
    private int $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt;

    public function __construct(
        string $title,
    ) {
        $this->title = $title;
        $this->changeStatus(TaskStatus::NEW);
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function changeTitle(string $title): Task
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): TaskStatus
    {
        return TaskStatus::from($this->status);
    }

    public function changeStatus(TaskStatus $status): Task
    {
        $this->status = $status->value;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function updated(): Task
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
