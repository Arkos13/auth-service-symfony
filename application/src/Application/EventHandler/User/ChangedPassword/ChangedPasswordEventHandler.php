<?php

namespace App\Application\EventHandler\User\ChangedPassword;

use App\Model\Shared\Event\EventHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Event\ChangedPasswordEvent;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;

class ChangedPasswordEventHandler implements EventHandlerInterface
{
    private MailServiceInterface $mailService;
    private UserRepositoryInterface $userRepository;

    public function __construct(MailServiceInterface $mailService,
                                UserRepositoryInterface $userRepository)
    {
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
    }

    public function __invoke(ChangedPasswordEvent $event): void
    {
        $user = $this->userRepository->findOneByEmail($event->email);

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        $this->mailService->sendEmail(
            $event->email,
            "",
            "password-changed.html.twig",
            true
        );

    }


}