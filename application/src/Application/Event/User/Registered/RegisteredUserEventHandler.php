<?php

namespace App\Application\Event\User\Registered;

use App\Application\Event\EventHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Model\User\Service\Token\TokenGeneratorInterface;

class RegisteredUserEventHandler implements EventHandlerInterface
{
    private MailServiceInterface $mailService;
    private UserRepositoryInterface $userRepository;
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(MailServiceInterface $mailService,
                                UserRepositoryInterface $userRepository,
                                TokenGeneratorInterface $tokenGenerator)
    {
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(RegisteredUserEvent $event): void
    {
        $user = $this->userRepository->findOneByEmail($event->getEmail());

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        $token = $this->tokenGenerator->generateConfirmationToken($user);

        $this->mailService->sendEmail(
            $event->getEmail(),
            "",
            "confirm_user.html.twig",
            true,
            ['url' => $event->getUrl()."?token={$token}"]
        );

    }


}