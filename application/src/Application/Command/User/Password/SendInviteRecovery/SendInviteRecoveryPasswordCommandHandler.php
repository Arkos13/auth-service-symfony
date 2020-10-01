<?php

namespace App\Application\Command\User\Password\SendInviteRecovery;

use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Model\User\Service\Token\TokenGeneratorInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendInviteRecoveryPasswordCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private TokenGeneratorInterface $tokenGenerator;
    private MailServiceInterface $mailService;

    public function __construct(UserRepositoryInterface $userRepository,
                                TokenGeneratorInterface $tokenGenerator,
                                MailServiceInterface $mailService)
    {
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailService = $mailService;
    }

    public function __invoke(SendInviteRecoveryPasswordCommand $command)
    {
        $user = $this->userRepository->findOneByEmail($command->getEmail());

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        $token = $this->tokenGenerator->generateConfirmationToken($user);

        $this->mailService->sendEmail(
            $command->getEmail(),
            "",
            "confirm_user.html.twig",
            true,
            ['url' => $command->getUrl()."?token={$token}"]
        );
    }


}