<?php

namespace App\Application\Query\User\GetInfoByEmail;

use App\Application\Query\QueryHandlerInterface;
use App\Application\Query\User\DTO\UserDTO;
use App\Model\User\Repository\UserRepositoryInterface;

class GetInfoUserByEmailQueryHandler implements QueryHandlerInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetInfoUserByEmailQuery $query): UserDTO
    {
        $user = $this->userRepository->getOneByEmail($query->email);

        return new UserDTO(
            $user->id,
            $user->email,
            $user->profile->firstName,
            $user->profile->lastName
        );
    }


}