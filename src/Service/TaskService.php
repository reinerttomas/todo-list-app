<?php
declare(strict_types=1);

namespace App\Service;

use App\Business\TaskCreateBusiness;
use App\Business\TaskRemoveBusiness;
use App\Business\TaskStatusBusiness;
use App\Business\TaskUpdateBusiness;
use App\Component\Http\FilterInterface;
use App\Dto\TaskRequest;
use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Exception\ORM\NotFoundException;
use App\Exception\ORM\ORMRemoveException;
use App\Exception\ORM\ORMStoreException;
use App\Repository\TaskRepository;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository,
        private TaskCreateBusiness $taskCreateBusiness,
        private TaskUpdateBusiness $taskUpdateBusiness,
        private TaskStatusBusiness $taskStatusBusiness,
        private TaskRemoveBusiness $taskRemoveBusiness,
    ) {
    }

    /**
     * @return array<Task>
     */
    public function list(FilterInterface $filter): array
    {
        return $this->taskRepository->list($filter);
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
    public function update(Task $task, TaskRequest $request): Task
    {
        return $this->taskUpdateBusiness->update($task, $request);
    }

    /**
     * @throws ORMStoreException
     */
    public function changeStatus(Task $task, TaskStatus $status): Task
    {
        return $this->taskStatusBusiness->changeStatus($task, $status);
    }

    /**
     * @throws ORMRemoveException
     */
    public function remove(Task $task): void
    {
        $this->taskRemoveBusiness->remove($task);
    }
}
