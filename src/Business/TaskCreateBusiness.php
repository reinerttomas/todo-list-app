<?php
declare(strict_types=1);

namespace App\Business;

use App\Dto\TaskRequest;
use App\Entity\Task;
use App\Exception\ORM\ORMStoreException;
use App\Repository\TaskRepository;

class TaskCreateBusiness
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    /**
     * @throws ORMStoreException
     */
    public function create(TaskRequest $request): Task
    {
        $task = new Task($request->title);

        return $this->taskRepository->store($task);
    }
}