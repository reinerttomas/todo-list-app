<?php
declare(strict_types=1);

namespace App\Business;

use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Exception\ORM\ORMStoreException;
use App\Repository\TaskRepository;

class TaskStatusBusiness
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    /**
     * @throws ORMStoreException
     */
    public function changeStatus(Task $task, TaskStatus $status): Task
    {
        $task
            ->changeStatus($status)
            ->updated();

        return $this->taskRepository->store($task);
    }
}
