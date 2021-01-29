<?php

namespace App\Application\EventHandler\User\Registered;

use App\Model\Shared\Event\EventHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Event\RegisteredUserEvent;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\User\Token\TokenGeneratorInterface;

class RegisteredUserEventHandler implements EventHandlerInterface
{
    private MailServiceInterface $mailService;
    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(MailServiceInterface $mailService,
                                UserRepositoryInterface $userRepository,
                                UserProfileRepositoryInterface $userProfileRepository,
                                TokenGeneratorInterface $tokenGenerator)
    {
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function __invoke(RegisteredUserEvent $event): void
    {
        $user = $this->userRepository->findOneByEmail($event->email);

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        $token = $this->tokenGenerator->generateConfirmationToken($user);
        $profile = $this->userProfileRepository->getOneByUserId($user->id);

        $this->mailService->sendEmail(
            $event->email,
            "",
            "confirmation-of-registration.html.twig",
            true,
            [
                'fullName' => $profile->getFullName(),
                'token' => $token
            ]
        );

    }


}