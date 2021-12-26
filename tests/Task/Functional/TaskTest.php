<?php
declare(strict_types=1);

namespace App\Tests\Task\Functional;

use App\Exception\Runtime\JsonException;
use App\Utils\Json;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testGet(): void
    {
        $client = self::createClient();
        $client->request('GET', 'api/task');

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
     * @throws JsonException
     */
    public function testGetById(): void
    {
        $client = self::createClient();
        $client->request('GET', 'api/task/1');

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
            'id' => 1,
            [
                'title' => 'Úkol 1x',
            ],
        ];

        yield [
            'id' => 2,
            [
                'title' => 'Úkol 2x',
            ],
        ];
    }

    public function provideDeleteData(): iterable
    {
        yield [
            'id' => 3,
        ];

        yield [
            'id' => 4,
        ];
    }
}
