<?php

namespace App\Application\Command\User\Email\ConfirmUserByEmail;

use App\Application\Command\CommandHandlerInterface;
use App\Model\User\Exception\ConfirmEmailTokenNotFoundException;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class ConfirmUserByEmailCommandHandler implements CommandHandlerInterface
{
    private ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->confirmEmailTokenRepository = $confirmEmailTokenRepository;
        $this->userRepository = $userRepository;
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
    }
}