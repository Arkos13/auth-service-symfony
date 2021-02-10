<?php

namespace App\Application\Command\User\Phone\Edit;

use App\Application\Command\CommandHandlerInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class EditPhoneCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(EditPhoneCommand $command): void
    {
        $user = $this->userRepository->getOneById($command->profileId);

        $user->setPhone($command->phone);
        $this->userRepository->add($user);
    }
}