<?php

namespace App\Application\Command\User\Email\SendChangeInvite;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Application\Service\User\ConfirmEmailToken\ConfirmEmailTokenFactoryAbstract;
use App\Application\Service\User\ConfirmEmailToken\Data as ConfirmEmailTokenFactoryData;

class SendChangeInviteCommandHandler implements CommandHandlerInterface
{
    private MailServiceInterface $mailService;
    private UserRepositoryInterface $userRepository;
    private ConfirmEmailTokenFactoryAbstract $confirmEmailTokenFactory;

    public function __construct(MailServiceInterface $mailService,
                                UserRepositoryInterface $userRepository,
                                ConfirmEmailTokenFactoryAbstract $confirmEmailTokenFactory)
    {
        $this->mailService = $mailService;
        $this->userRepository = $userRepository;
        $this->confirmEmailTokenFactory = $confirmEmailTokenFactory;
    }

    public function __invoke(SendChangeInviteCommand $command): void
    {
        $user = $this->userRepository->findOneByEmail($command->email);

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        if ($this->userRepository->findOneByEmail($command->newEmail)) {
            throw new EmailInviteException('This email already exists');
        }

        $token = $this->confirmEmailTokenFactory->create(
            new ConfirmEmailTokenFactoryData($user, $command->newEmail)
        );

        $this->mailService->sendEmail(
            $command->newEmail,
            "",
            "change_email.html.twig",
            true,
            ['url' => $command->url."?token={$token->confirmationEmailToken}"]
        );
    }


}