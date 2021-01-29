<?php

namespace App\Application\Command\User\Email\ConfirmUserByEmail;

use App\Application\Command\CommandHandlerInterface;
use App\Model\Shared\Event\EventBusInterface;
use App\Model\User\Exception\ConfirmEmailTokenNotFoundException;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class ConfirmUserByEmailCommandHandler implements CommandHandlerInterface
{
    private ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository;
    private UserRepositoryInterface $userRepository;
    private EventBusInterface $eventBus;

    public function __construct(ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository,
                                UserRepositoryInterface $userRepository,
                                EventBusInterface $eventBus)
    {
        $this->confirmEmailTokenRepository = $confirmEmailTokenRepository;
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(ConfirmUserByEmailCommand $command): void
    {
        $confirmEmailToken = $this->confirmEmailTokenRepository->findOneByToken($command->token);

        if (!$confirmEmailToken) {
            throw new ConfirmEmailTokenNotFoundException();
        }

        if (!$confirmEmailToken->isValidExpiresToken()) {
            throw new TokenExpiredException();
        }

        $user = $confirmEmailToken->user;
        $user->setEmail($confirmEmailToken->email);
        $this->userRepository->add($user);

        $this->confirmEmailTokenRepository->remove($confirmEmailToken);

        $this->eventBus->handle(...$user->pullDomainEvents());
    }
}