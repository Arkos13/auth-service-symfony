<?php

namespace App\Ports\Rest\Action\OAuth\Network;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CheckAction extends AbstractController
{

    /**
     * @Route("/open_api/networks/check", methods={"GET"}, name="networks_check")
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(1);
    }
}
