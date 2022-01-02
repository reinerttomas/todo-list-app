<?php
declare(strict_types=1);

namespace App\Component\Query;

use App\Component\Http\FilterInterface as HttpFilterInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    public function __construct(QueryBuilder $qb, HttpFilterInterface $filter);

    public function getQuery(): Query;
}
