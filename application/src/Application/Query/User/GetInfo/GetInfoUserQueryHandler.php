<?php

namespace App\Application\Query\User\GetInfo;

use App\Application\Query\QueryHandlerInterface;
use App\Application\Query\User\DTO\UserDTO;
use App\Model\User\Repository\UserRepositoryInterface;

class GetInfoUserQueryHandler implements QueryHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetInfoUserQuery $query): UserDTO
    {
        $user = $this->userRepository->getOneById($query->userId);

        return new UserDTO(
            $user->id,
            $user->email,
            $user->profile->firstName,
            $user->profile->lastName
        );
    }


}