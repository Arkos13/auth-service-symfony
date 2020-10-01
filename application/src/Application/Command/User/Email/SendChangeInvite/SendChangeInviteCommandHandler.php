<?php

namespace App\Application\Command\User\Email\SendChangeInvite;

use App\Application\Service\Mail\MailServiceInterface;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Model\User\Service\ConfirmEmailToken\Factory\ConfirmEmailTokenFactoryAbstract;
use App\Model\User\Service\ConfirmEmailToken\Factory\Data as ConfirmEmailTokenFactoryData;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendChangeInviteCommandHandler implements MessageHandlerInterface
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
        $user = $this->userRepository->findOneByEmail($command->getEmail());

        if (!$user) {
            throw new EmailInviteException('User not found');
        }

        if ($this->userRepository->findOneByEmail($command->getNewEmail())) {
            throw new EmailInviteException('This email already exists');
        }

        $token = $this->confirmEmailTokenFactory->create(
            new ConfirmEmailTokenFactoryData($user, $command->getNewEmail())
        );

        $this->mailService->sendEmail(
            $command->getNewEmail(),
            "",
            "change_email.html.twig",
            true,
            ['url' => $command->getUrl()."?token={$token->getConfirmationEmailToken()}"]
        );
    }


}