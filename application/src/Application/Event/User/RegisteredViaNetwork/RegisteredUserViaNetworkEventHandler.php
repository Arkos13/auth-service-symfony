<?php

namespace App\Application\Event\User\RegisteredViaNetwork;

use App\Application\Event\EventHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;

class RegisteredUserViaNetworkEventHandler implements EventHandlerInterface
{
    private MailServiceInterface $mailerService;

    public function __construct(MailServiceInterface $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function __invoke(RegisteredUserViaNetworkEvent $event): void
    {
        $this->mailerService->sendEmail(
            $event->getEmail(),
            "",
            "password.html.twig",
            true,
            ['password' => $event->getPassword()]
        );
    }


}