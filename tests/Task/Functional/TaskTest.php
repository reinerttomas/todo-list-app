<?php
declare(strict_types=1);

namespace App\Tests\Task\Functional;

use App\Entity\TaskStatus;
use App\Exception\Runtime\JsonException;
use App\Utils\Json;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testList(): void
    {
        $client = self::createClient();
        $client->request(
            'POST',
            'api/task/list',
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = Json::decode($response->getContent());

        self::assertIsArray($data);

        $task = $data[0];

        self::assertIsArray($task);
        self::assertArrayHasKey('id', $task);
        self::assertArrayHasKey('title', $task);
        self::assertArrayHasKey('status', $task);
        self::assertArrayHasKey('createdAt', $task);
        self::assertArrayHasKey('updatedAt', $task);
    }

    /**
     * @dataProvider provideGetByIdData
     * @throws JsonException
     */
    public function testGet(int $id): void
    {
        $client = self::createClient();
        $client->request('GET', 'api/task/' . $id);

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = Json::decode($response->getContent());

        self::assertIsArray($data);
        self::assertArrayHasKey('id', $data);
        self::assertArrayHasKey('title', $data);
        self::assertArrayHasKey('status', $data);
        self::assertArrayHasKey('createdAt', $data);
        self::assertArrayHasKey('updatedAt', $data);
    }

    /**
     * @dataProvider providePostData
     * @throws JsonException
     */
    public function testPost(array $body): void
    {
        $client = self::createClient();
        $client->request(
            'POST',
            'api/task',
            $body,
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $data = Json::decode($response->getContent());

        self::assertIsArray($data);
        self::assertArrayHasKey('id', $data);
        self::assertArrayHasKey('title', $data);
        self::assertArrayHasKey('status', $data);
        self::assertArrayHasKey('createdAt', $data);
        self::assertArrayHasKey('updatedAt', $data);
    }

    /**
     * @dataProvider providePutData
     * @throws JsonException
     */
    public function testPut(int $id, array $body): void
    {
        $client = self::createClient();
        $client->request(
            'PUT',
            'api/task/' . $id,
            $body,
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = Json::decode($response->getContent());

        self::assertIsArray($data);
        self::assertArrayHasKey('id', $data);
        self::assertArrayHasKey('title', $data);
        self::assertArrayHasKey('status', $data);
        self::assertArrayHasKey('createdAt', $data);
        self::assertArrayHasKey('updatedAt', $data);
    }

    /**
     * @dataProvider provideDeleteData
     */
    public function testDelete(int $id): void
    {
        $client = self::createClient();
        $client->request(
            'DELETE',
            'api/task/' . $id,
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @dataProvider provideStatusData
     * @throws JsonException
     */
    public function testStatus(int $id, array $body): void
    {
        $client = self::createClient();
        $client->request(
            'PUT',
            'api/task/' . $id . '/status',
            $body,
        );

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $data = Json::decode($response->getContent());

        self::assertIsArray($data);
        self::assertArrayHasKey('id', $data);
        self::assertArrayHasKey('title', $data);
        self::assertArrayHasKey('status', $data);
        self::assertArrayHasKey('createdAt', $data);
        self::assertArrayHasKey('updatedAt', $data);
    }

    public function provideGetByIdData(): iterable
    {
        yield [
            'id' => 10,
        ];

        yield [
            'id' => 11,
        ];
    }

    public function providePostData(): iterable
    {
        yield [
            [
                'title' => 'Úkol 1',
            ],
        ];

        yield [
            [
                'title' => 'Úkol 2',
            ],
        ];
    }

    public function providePutData(): iterable
    {
        yield [
            'id' => 12,
            [
                'title' => 'Úkol 1x',
            ],
        ];

        yield [
            'id' => 13,
            [
                'title' => 'Úkol 2x',
            ],
        ];
    }

    public function provideDeleteData(): iterable
    {
        yield [
            'id' => 14,
        ];

        yield [
            'id' => 15,
        ];
    }

    public function provideStatusData(): iterable
    {
        yield [
            'id' => 16,
            [
                'status' => TaskStatus::DONE->value,
            ],
        ];

        yield [
            'id' => 16,
            [
                'status' => TaskStatus::NEW->value,
            ],
        ];
    }
}
