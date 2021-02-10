<?php

namespace App\Application\Command\User\Profile\Edit;

use App\Application\Command\CommandHandlerInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class EditUserProfileCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditUserProfileCommand $command): void
    {
        $user = $this->repository->getOneById($command->userId);

        $user->editProfile(
            $command->firstName,
            $command->lastName,
            $command->birthday,
            $command->gender
        );
        $this->repository->add($user);
    }


}