<?php

namespace App\Application\Command\User\Confirm;

use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Exception\UserConfirmationTokenNotFoundException;
use App\Model\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ConfirmUserCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ConfirmUserCommand $command): void
    {
        $user = $this->userRepository->findOneByConfirmationToken($command->getToken());

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