<?php
declare(strict_types=1);

namespace App\Business;

use App\Dto\TaskRequest;
use App\Entity\Task;
use App\Exception\ORM\ORMStoreException;
use App\Repository\TaskRepository;

class TaskUpdateBusiness
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    /**
     * @throws ORMStoreException
     */
    public function update(Task $task, TaskRequest $request): Task
    {
        $task->changeTitle($request->title)
            ->updated();

        return $this->taskRepository->store($task);
    }
}