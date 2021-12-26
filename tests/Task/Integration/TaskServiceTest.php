<?php
declare(strict_types=1);

namespace App\Tests\Task\Integration;

use App\Core\HttpFilter\HttpFilter;
use App\Dto\TaskRequest;
use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Exception\ORM\NotFoundException;
use App\Exception\ORM\ORMRemoveException;
use App\Exception\ORM\ORMStoreException;
use App\Service\TaskService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskServiceTest extends KernelTestCase
{
    private TaskService $taskService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->taskService = $container->get(TaskService::class);
    }

    public function testList(): void
    {
        $filter = new HttpFilter(100, 0);
        $tasks = $this->taskService->list($filter);

        self::assertIsArray($tasks);
        self::assertContainsOnlyInstancesOf(Task::class, $tasks);
    }

    /**
     * @dataProvider provideGetData
     * @throws NotFoundException
     */
    public function testGet(
        int $id,
        string $title,
        TaskStatus $status,
        DateTime $createdAt,
        ?DateTime $updatedAt,
    ): void {
        $task = $this->taskService->get($id);

        self::assertEquals($id, $task->getId());
        self::assertEquals($title, $task->getTitle());
        self::assertEquals($status->value, $task->getStatus()->value);
        self::assertEquals($createdAt->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($updatedAt?->format('Y-m-d'), $task->getUpdatedAt()?->format('Y-m-d'));
    }

    public function testNotFound(): void
    {
        self::expectException(NotFoundException::class);
        self::expectExceptionMessage('Task not found.');

        $this->taskService->get(999);
    }

    /**
     * @dataProvider provideCreateData
     * @throws ORMStoreException
     */
    public function testCreate(array $expect, array $input): void
    {
        $request = new TaskRequest();
        $request->title = $input['title'];

        $task = $this->taskService->create($request);

        self::assertEquals($expect['title'], $task->getTitle());
        self::assertEquals($expect['status']->value, $task->getStatus()->value);
        self::assertEquals($expect['createdAt']->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($expect['updatedAt']?->format('Y-m-d'), $task->getUpdatedAt()?->format('Y-m-d'));
    }

    /**
     * @dataProvider provideUpdateData
     * @throws NotFoundException
     * @throws ORMStoreException
     */
    public function testUpdate(array $expect, array $input): void
    {
        $task = $this->taskService->get($input['id']);

        $request = TaskRequest::from($task);
        $request->title = $input['title'];

        $task = $this->taskService->update($task, $request);

        self::assertEquals($expect['id'], $task->getId());
        self::assertEquals($expect['title'], $task->getTitle());
        self::assertEquals($expect['status']->value, $task->getStatus()->value);
        self::assertEquals($expect['createdAt']->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($expect['updatedAt']->format('Y-m-d'), $task->getUpdatedAt()->format('Y-m-d'));
    }

    /**
     * @dataProvider provideRemoveData
     * @throws NotFoundException
     * @throws ORMRemoveException
     */
    public function testRemove(int $id): void
    {
        $task = $this->taskService->get($id);

        $this->taskService->remove($task);

        self::expectException(NotFoundException::class);
        self::expectExceptionMessage('Task not found.');

        $this->taskService->get($id);
    }

    /**
     * @dataProvider provideChangeStatusData
     * @throws NotFoundException
     * @throws ORMStoreException
     */
    public function testChangeStatus(array $expect, array $input): void
    {
        $task = $this->taskService->get($input['id']);

        $task = $this->taskService->changeStatus($task, $input['status']);

        self::assertEquals($task->getId(), $expect['id']);
        self::assertEquals($task->getStatus()->value, $expect['status']->value);
        self::assertEquals($expect['createdAt']->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($expect['updatedAt']->format('Y-m-d'), $task->getUpdatedAt()->format('Y-m-d'));
    }

    public function provideGetData(): iterable
    {
        yield [
            'id' => 1,
            'title' => 'Vysypat koš v pondělí',
            'status' => TaskStatus::NEW,
            'createdAt' => new DateTime(),
            'updatedAt' => null,
        ];

        yield [
            'id' => 2,
            'title' => 'Vyzvednout balíček',
            'status' => TaskStatus::NEW,
            'createdAt' => new DateTime(),
            'updatedAt' => null,
        ];
    }

    public function provideCreateData(): iterable
    {
        yield [
            [
                'title' => 'Task 1',
                'status' => TaskStatus::NEW,
                'createdAt' => new DateTime(),
                'updatedAt' => null,
            ],
            [
                'title' => 'Task 1',
            ],
        ];
    }

    public function provideUpdateData(): iterable
    {
        yield [
            [
                'id' => 3,
                'title' => 'Task 1xxx',
                'status' => TaskStatus::NEW,
                'createdAt' => new DateTime(),
                'updatedAt' => new DateTime(),
            ],
            [
                'id' => 3,
                'title' => 'Task 1xxx',
            ],
        ];
    }

    public function provideRemoveData(): iterable
    {
        yield [
            'id' => 4,
        ];
    }

    public function provideChangeStatusData(): iterable
    {
        yield [
            [
                'id' => 5,
                'status' => TaskStatus::DONE,
                'createdAt' => new DateTime(),
                'updatedAt' => new DateTime(),
            ],
            [
                'id' => 5,
                'status' => TaskStatus::DONE,
            ],
        ];

        yield [
            [
                'id' => 5,
                'status' => TaskStatus::NEW,
                'createdAt' => new DateTime(),
                'updatedAt' => new DateTime(),
            ],
            [
                'id' => 5,
                'status' => TaskStatus::NEW,
            ],
        ];
    }
}
