<?php
declare(strict_types=1);

namespace App\Tests\Utils;

use App\Exception\Runtime\JsonException;
use App\Utils\Json;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    /**
     * @dataProvider provideEncodeData
     * @throws JsonException
     */
    public function testEncode(array $expect, array $input): void
    {
        $json = Json::encode($input);

        self::assertEquals($expect['length'], strlen($json));
        self::assertEquals($expect['json'], $json);
    }

    /**
     * @dataProvider provideDecodeData
     * @throws JsonException
     */
    public function testDecode(array $expect, array $input): void
    {
        $data = Json::decode($input['json']);

        self::assertEquals($expect['string'], $data['string']);
        self::assertEquals($expect['int'], $data['int']);
        self::assertEquals($expect['float'], $data['float']);
        self::assertEquals($expect['bool'], $data['bool']);
        self::assertEquals($expect['date'], $data['date']);
    }

    /**
     * @dataProvider provideValidateData
     */
    public function testValidate(bool $expect, string $json): void
    {
        $result = Json::validate($json);

        self::assertEquals($expect, $result);
    }

    public function provideEncodeData(): iterable
    {
        yield [
            [
                'length' => 70,
                'json' => '{"string":"text","int":10,"float":9.9,"bool":true,"date":"2020-01-01"}',
            ],
            [
                'string' => 'text',
                'int' => 10,
                'float' => 9.9,
                'bool' => true,
                'date' => '2020-01-01',
            ],
        ];

        yield [
            [
                'length' => 80,
                'json' => '{"string":"lorem ipsum","int":100,"float":99.9,"bool":false,"date":"2021-12-31"}',
            ],
            [
                'string' => 'lorem ipsum',
                'int' => 100,
                'float' => 99.9,
                'bool' => false,
                'date' => '2021-12-31',
            ],
        ];
    }

    public function provideDecodeData(): iterable
    {
        yield [
            [
                'string' => 'hello world',
                'int' => 1000,
                'float' => 999.9,
                'bool' => true,
                'date' => '2022-01-01',
            ],
            [
                'json' => '{"string":"hello world","int":1000,"float":999.9,"bool":true,"date":"2022-01-01"}',
            ],
        ];

        yield [
            [
                'string' => 'lorem ipsum',
                'int' => 1,
                'float' => 9.99,
                'bool' => false,
                'date' => '2022-12-31',
            ],
            [
                'json' => '{"string":"lorem ipsum","int":1,"float":9.99,"bool":false,"date":"2022-12-31"}',
            ],
        ];
    }

    public function provideValidateData(): iterable
    {
        yield [
            'expect' => true,
            'json' => '{"string":"hello world","int":1000,"float":999.9,"bool":true,"date":"2022-01-01"}',
        ];

        yield [
            'expect' => false,
            'json' => '{"string","int":1000,"float":999.9,"bool":true,"date":"2022-01-01"}',
        ];
    }
}
