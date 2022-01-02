<?php
declare(strict_types=1);

namespace App\Component\Http;

class Filter implements FilterInterface
{
    private int $limit;
    private int $offset;

    public function __construct(int $limit = 20, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }
}
