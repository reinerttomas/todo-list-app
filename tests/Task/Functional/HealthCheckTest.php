<?php
declare(strict_types=1);

namespace App\Tests\Task\Functional;

use App\Exception\Runtime\JsonException;
use App\Utils\Json;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testPing(): void
    {
        $client = self::createClient();
        $client->request('GET', 'api/ping');

        $response = $client->getResponse();
        $data = Json::decode($response->getContent());

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals('pong', $data['message']);
    }
}
