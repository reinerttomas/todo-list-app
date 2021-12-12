<?php

namespace App\Controller\Api;

use App\Dto\TaskRequest;
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
    ) {}

    #[Rest\Get("/task")]
    public function listAction(): View
    {
        $tasks = $this->taskService->list();

        return $this->view($tasks, Response::HTTP_OK);
    }

    #[Rest\Get("/task/{id}")]
    public function getAction(int $id): View
    {
        $task = $this->taskService->get($id);

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
}
