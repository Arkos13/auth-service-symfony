<?php

namespace App\Ports\Rest\Action;

use App\Infrastructure\User\Security\UserIdentity;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

abstract class BaseAction extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getCurrentUser(): UserIdentity
    {
        if (is_null($user = $this->getUser())) {
            throw new UnauthorizedHttpException("User does not unauthorized");
        }

        /** @var UserIdentity $user */
        return $user;
    }

    /**
     * @param mixed $data
     * @return Response
     */
    public function jsonResponse($data): Response
    {
        return new Response($this->serializer->serialize($data, 'json'));
    }
}
