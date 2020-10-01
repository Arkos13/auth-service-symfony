<?php

namespace App\Application\Event\User\RegisteredViaNetwork;

use App\Application\Service\Mail\MailServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisteredUserViaNetworkEventHandler implements MessageHandlerInterface
{
    private MailServiceInterface $mailerService;

    public function __construct(MailServiceInterface $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    public function __invoke(RegisteredUserViaNetworkEvent $event)
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