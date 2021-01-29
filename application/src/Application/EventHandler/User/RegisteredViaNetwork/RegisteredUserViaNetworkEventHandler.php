<?php

namespace App\Application\EventHandler\User\RegisteredViaNetwork;

use App\Model\Shared\Event\EventHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Event\RegisteredUserViaNetworkEvent;

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
            $event->email,
            "",
            "password.html.twig",
            true,
            ['password' => $event->password]
        );
    }


}