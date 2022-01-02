<?php
declare(strict_types=1);

namespace App\Component\Http;

interface FilterInterface
{
    public function getLimit(): int;

    public function setLimit(int $limit): void;

    public function getOffset(): int;

    public function setOffset(int $offset): void;
}
