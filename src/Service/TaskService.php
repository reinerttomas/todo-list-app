<?php
declare(strict_types=1);

namespace App\Service;

use App\Business\TaskCreateBusiness;
use App\Business\TaskRemoveBusiness;
use App\Business\TaskStatusBusiness;
use App\Dto\TaskRequest;
use App\Entity\Task;
use App\Exception\ORM\NotFoundException;
use App\Exception\ORM\ORMRemoveException;
use App\Exception\ORM\ORMStoreException;
use App\Repository\TaskRepository;

class TaskService
{
    public function __construct(
        private TaskRepository     $taskRepository,
        private TaskCreateBusiness $taskCreateBusiness,
        private TaskStatusBusiness $taskStatusBusiness,
        private TaskRemoveBusiness $taskRemoveBusiness,
    ) {}

    /**
     * @return Task[]
     */
    public function list(): array
    {
        return $this->taskRepository->list();
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Task
    {
        return $this->taskRepository->get($id);
    }

    /**
     * @throws ORMStoreException
     */
    public function create(TaskRequest $request): Task
    {
        return $this->taskCreateBusiness->create($request);
    }


    /**
     * @throws ORMStoreException
     */
    public function switchStatus(Task $task): Task
    {
        return $this->taskStatusBusiness->switchStatus($task);
    }

    /**
     * @throws ORMRemoveException
     */
    public function remove(Task $task): void
    {
        $this->taskRemoveBusiness->remove($task);
    }
}