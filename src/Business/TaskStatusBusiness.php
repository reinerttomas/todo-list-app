<?php
declare(strict_types=1);

namespace App\Business;

use App\Entity\Task;
use App\Exception\ORM\ORMStoreException;
use App\Repository\TaskRepository;

class TaskStatusBusiness
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    /**
     * @throws ORMStoreException
     */
    public function switchStatus(Task $task): Task
    {
        $task
            ->switchStatus()
            ->updated();

        return $this->taskRepository->store($task);
    }
}