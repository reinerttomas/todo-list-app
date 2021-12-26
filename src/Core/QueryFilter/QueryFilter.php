<?php
declare(strict_types=1);

namespace App\Core\QueryFilter;

use App\Core\HttpFilter\HttpFilterInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class QueryFilter implements QueryFilterInterface
{
    private QueryBuilder $qb;
    private HttpFilterInterface $filter;

    public function __construct(QueryBuilder $qb, HttpFilterInterface $filter)
    {
        $this->qb = $qb;
        $this->filter = $filter;
    }

    public function getQuery(): Query
    {
        $this->qb
            ->setMaxResults($this->filter->getLimit())
            ->setFirstResult($this->filter->getOffset());

        return $this->qb->getQuery();
    }
}
