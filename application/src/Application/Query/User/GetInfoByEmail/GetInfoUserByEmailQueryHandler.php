<?php

namespace App\Application\Query\User\GetInfoByEmail;

use App\Application\Query\QueryHandlerInterface;
use App\Application\Query\User\DTO\UserDTO;
use App\Model\User\Exception\UserNotExistsException;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;

class GetInfoUserByEmailQueryHandler implements QueryHandlerInterface
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetInfoUserByEmailQuery $query): UserDTO
    {
        $user = $this->userRepository->findOneByEmail($query->getEmail());
        $userProfile = $user ? $this->userProfileRepository->findOneByUserId($user->getId()) : null;

        if (empty($user) || empty($userProfile)) {
            throw new UserNotExistsException();
        }

        return new UserDTO(
            $user->getId(),
            $user->getEmail(),
            $userProfile->getFirstName(),
            $userProfile->getLastName()
        );
    }


}