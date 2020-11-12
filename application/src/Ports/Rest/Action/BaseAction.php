<?php

namespace App\Ports\Rest\Action;

use App\Model\User\Entity\User;
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

    public function getCurrentUser(): User
    {
        if (is_null($user = $this->getUser())) {
            throw new UnauthorizedHttpException("User does not unauthorized");
        }

        /** @var User $user */
        return $user;
    }

    /**
     * @param mixed $data
     * @return Response
     */
    public function jsonResponse($data)
    {
        return new Response($this->serializer->serialize($data, 'json'));
    }
}
