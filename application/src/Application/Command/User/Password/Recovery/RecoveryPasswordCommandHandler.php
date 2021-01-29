<?php

namespace App\Application\Command\User\Password\Recovery;

use App\Application\Command\CommandHandlerInterface;
use App\Model\Shared\Event\EventBusInterface;
use App\Application\Service\PasswordHasher\PasswordHasherInterface;
use App\Model\User\Exception\ConfirmPasswordTokenNotFoundException;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Repository\ConfirmPasswordTokenRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class RecoveryPasswordCommandHandler implements CommandHandlerInterface
{
    private ConfirmPasswordTokenRepositoryInterface $confirmPasswordTokenRepository;
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;
    private EventBusInterface $eventBus;

    public function __construct(ConfirmPasswordTokenRepositoryInterface $confirmPasswordTokenRepository,
                                UserRepositoryInterface $userRepository,
                                PasswordHasherInterface $passwordHasher,
                                EventBusInterface $eventBus)
    {
        $this->confirmPasswordTokenRepository = $confirmPasswordTokenRepository;
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->eventBus = $eventBus;
    }

    public function __invoke(RecoveryPasswordCommand $command): void
    {
        $confirmToken = $this->confirmPasswordTokenRepository->findOneByToken($command->getConfirmationToken());

        if (!$confirmToken) {
            throw new ConfirmPasswordTokenNotFoundException();
        }

        if (!$confirmToken->isValidExpiresToken()) {
            throw new TokenExpiredException();
        }

        $user = $confirmToken->user;

        $user->setPassword($this->passwordHasher->hash($command->getPassword()));
        $this->userRepository->add($user);
        $this->confirmPasswordTokenRepository->remove($confirmToken);

        $this->eventBus->handle(...$user->pullDomainEvents());
    }


}