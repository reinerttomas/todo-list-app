<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\TaskRequest;
use App\Dto\TaskStatusChangeRequest;
use App\Exception\ORM\NotFoundException;
use App\Factory\HttpFilterFactory;
use App\Form\TaskStatusChangeType;
use App\Form\TaskType;
use App\Service\TaskService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractFOSRestController
{
    public function __construct(
        private TaskService $taskService,
        private HttpFilterFactory $httpFilterFactory,
    ) {
    }

    #[Rest\Post("/task/list")]
    public function listAction(Request $request): View
    {
        $filter = $this->httpFilterFactory->create($request);
        $tasks = $this->taskService->list($filter);

        return $this->view($tasks, Response::HTTP_OK);
    }

    #[Rest\Get("/task/{id}")]
    public function getAction(int $id): View
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException) {
            throw $this->createNotFoundException();
        }

        return $this->view($task, Response::HTTP_OK);
    }

    #[Rest\Post("/task")]
    public function postAction(Request $request): View
    {
        $taskRequest = new TaskRequest();

        $form = $this->createForm(TaskType::class, $taskRequest);
        $form->submit($request->request->all());

        if ($form->isValid() === false) {
            return $this->view($form);
        }

        $task = $this->taskService->create($taskRequest);

        return $this->view($task, Response::HTTP_CREATED);
    }

    #[Rest\Put("/task/{id}")]
    public function putAction(Request $request, int $id): View
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException) {
            throw $this->createNotFoundException();
        }

        $taskRequest = TaskRequest::from($task);

        $form = $this->createForm(TaskType::class, $taskRequest);
        $form->submit($request->request->all());

        if ($form->isValid() === false) {
            return $this->view($form);
        }

        $task = $this->taskService->update($task, $taskRequest);

        return $this->view($task, Response::HTTP_OK);
    }

    #[Rest\Delete("/task/{id}")]
    public function deleteAction(int $id): View
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException) {
            throw $this->createNotFoundException();
        }

        $this->taskService->remove($task);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    #[Rest\Put("/task/{id}/status")]
    public function statusAction(Request $request, int $id): View
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException) {
            throw $this->createNotFoundException();
        }

        $taskStatusChangeRequest = new TaskStatusChangeRequest();

        $form = $this->createForm(TaskStatusChangeType::class, $taskStatusChangeRequest);
        $form->submit($request->request->all());

        if ($form->isValid() === false) {
            return $this->view($form);
        }

        $task = $this->taskService->changeStatus($task, $taskStatusChangeRequest->status);

        return $this->view($task, Response::HTTP_OK);
    }
}
