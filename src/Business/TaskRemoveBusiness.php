<?php
declare(strict_types=1);

namespace App\Business;

use App\Entity\Task;
use App\Exception\ORM\ORMRemoveException;
use App\Repository\TaskRepository;

class TaskRemoveBusiness
{
    public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    /**
     * @throws ORMRemoveException
     */
    public function remove(Task $task): void
    {
        $this->taskRepository->remove($task);
    }
}
