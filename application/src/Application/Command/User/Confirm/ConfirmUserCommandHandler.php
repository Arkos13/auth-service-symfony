<?php

namespace App\Application\Command\User\Confirm;

use App\Application\Command\CommandHandlerInterface;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Exception\UserConfirmationTokenNotFoundException;
use App\Model\User\Repository\UserRepositoryInterface;

class ConfirmUserCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ConfirmUserCommand $command): void
    {
        $user = $this->userRepository->findOneByConfirmationToken($command->token);

        if (!$user) {
            throw new UserConfirmationTokenNotFoundException();
        }

        if (!$user->isValidExpiresConfirmationToken()) {
            throw new TokenExpiredException();
        }

        $user->setConfirmationToken(null);
        $user->setExpiresConfirmationToken(null);
        $this->userRepository->add($user);
    }


}