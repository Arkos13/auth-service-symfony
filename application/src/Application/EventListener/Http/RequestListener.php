<?php

namespace App\Application\EventListener\Http;

use App\Model\User\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestListener
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->extractingUser();
        if ($user && $user->getConfirmationToken()) {
            $event->setResponse(new JsonResponse("This user account is not confirmed", Response::HTTP_FORBIDDEN));
        }
    }

    private function extractingUser(): ?User
    {
        $token =  $this->tokenStorage->getToken();

        if ($token && $token->getUser() instanceof User) {
            /** @var User $user */
            $user = $token->getUser();
            return $user;
        }

        return null;
    }
}
