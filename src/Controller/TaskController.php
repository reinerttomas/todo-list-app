<?php

namespace App\Controller;

use App\Exception\Logic\NotFoundException;
use App\Exception\ORM\ORMRemoveException;
use App\Exception\ORM\ORMStoreException;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private TaskService $taskService,
    ) {}

    #[Route('/task', name: 'task_list', methods: 'GET')]
    public function list(): Response
    {
        $tasks = $this->taskService->list();

        return $this->json($tasks);
    }

    #[Route('/task/{id}', name: 'task_get', methods: 'GET')]
    public function task(int $id): Response
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException $e) {
            return $this->json($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return $this->json($task);
    }

    #[Route('/task', name: 'task_create', methods: 'POST')]
    public function create(Request $request): Response
    {
        //todo

        return $this->json(['ok']);
    }

    #[Route('/task/{id}/status', name: 'task_create', methods: 'PUT')]
    public function switchStatus(int $id): Response
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException $e) {
            return $this->json($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        try {
            $task = $this->taskService->switchStatus($task);
        } catch (ORMStoreException $e) {
            return $this->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json($task);
    }

    #[Route('/task/{id}', name: 'task_remove', methods: 'DELETE')]
    public function remove(int $id): Response
    {
        try {
            $task = $this->taskService->get($id);
        } catch (NotFoundException $e) {
            return $this->json($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        try {
            $this->taskService->remove($task);
        } catch (ORMRemoveException $e) {
            return $this->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([]);
    }
}
