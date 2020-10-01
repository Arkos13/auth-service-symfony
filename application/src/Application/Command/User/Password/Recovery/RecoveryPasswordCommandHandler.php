<?php

namespace App\Application\Command\User\Password\Recovery;

use App\Application\Service\PasswordHasher\PasswordHasherInterface;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Exception\UserConfirmationTokenNotFoundException;
use App\Model\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RecoveryPasswordCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(UserRepositoryInterface $userRepository,
                                PasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function __invoke(RecoveryPasswordCommand $command)
    {
        $user = $this->userRepository->findOneByConfirmationToken($command->getConfirmationToken());

        if (!$user) {
            throw new UserConfirmationTokenNotFoundException();
        }

        if (!$user->isValidExpiresConfirmationToken()) {
            throw new TokenExpiredException();
        }

        $user->setPassword($this->passwordHasher->hash($command->getPassword()));
        $user->setConfirmationToken(null);
        $user->setExpiresConfirmationToken(null);
        $this->userRepository->add($user);
    }


}