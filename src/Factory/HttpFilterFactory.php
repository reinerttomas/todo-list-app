<?php
declare(strict_types=1);

namespace App\Factory;

use App\Core\HttpFilter\HttpFilter;
use App\Core\HttpFilter\HttpFilterInterface;
use Symfony\Component\HttpFoundation\Request;

class HttpFilterFactory
{
    public function create(Request $request): HttpFilterInterface
    {
        $filter = new HttpFilter();

        /** @var int|null $limit */
        $limit = $request->get('limit');

        if ($limit !== null) {
            $filter->setLimit($limit);
        }

        /** @var int|null $offset */
        $offset = $request->get('offset');

        if ($offset !== null) {
            $filter->setOffset($offset);
        }

        return $filter;
    }
}
