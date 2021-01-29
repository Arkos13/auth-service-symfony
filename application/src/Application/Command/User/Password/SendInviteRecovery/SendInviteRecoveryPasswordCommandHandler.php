<?php

namespace App\Application\Command\User\Password\SendInviteRecovery;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\User\ConfirmPasswordToken\ConfirmPasswordTokenFactoryAbstract;

class SendInviteRecoveryPasswordCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private ConfirmPasswordTokenFactoryAbstract $tokenFactory;
    private MailServiceInterface $mailService;

    public function __construct(UserRepositoryInterface $userRepository,
                                ConfirmPasswordTokenFactoryAbstract $tokenFactory,
                                MailServiceInterface $mailService)
    {
        $this->userRepository = $userRepository;
        $this->tokenFactory = $tokenFactory;
        $this->mailService = $mailService;
    }

    public function __invoke(SendInviteRecoveryPasswordCommand $command): void
    {
        $user = $this->userRepository->findOneByEmail($command->getEmail());

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        $token = $this->tokenFactory->create($user);

        $this->mailService->sendEmail(
            $command->getEmail(),
            "",
            "request-password-restore.html.twig",
            true,
            ['token' => $token->confirmationEmailToken]
        );
    }


}