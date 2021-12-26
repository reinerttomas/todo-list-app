<?php
declare(strict_types=1);

namespace App\Utils;

use App\Exception\Runtime\JsonException;
use Throwable;

class Json
{
    /**
     * @phpstan-ignore-next-line
     * @throws JsonException
     */
    public static function encode(array $array): string
    {
        try {
            return json_encode($array, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new JsonException($e->getMessage());
        }
    }

    /**
     * @phpstan-ignore-next-line
     * @throws JsonException
     */
    public static function decode(string $json): array
    {
        try {
            /** @phpstan-ignore-next-line */
            return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new JsonException($e->getMessage());
        }
    }

    public static function validate(string $json): bool
    {
        $array = json_decode($json, true);

        if ($array === null) {
            return false;
        }

        return true;
    }
}
