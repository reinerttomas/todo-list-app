<?php
declare(strict_types=1);

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController extends AbstractFOSRestController
{
    #[Rest\Get("/ping")]
    public function pingAction(): View
    {
        return View::create('pong', Response::HTTP_OK);
    }
}
