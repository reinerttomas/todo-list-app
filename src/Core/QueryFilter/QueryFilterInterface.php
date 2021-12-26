<?php
declare(strict_types=1);

namespace App\Core\QueryFilter;

use App\Core\HttpFilter\HttpFilterInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface QueryFilterInterface
{
    public function __construct(QueryBuilder $qb, HttpFilterInterface $filter);

    public function getQuery(): Query;
}
