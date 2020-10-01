<?php

namespace App\Application\Query\User\GetInfo;

use App\Application\Query\User\DTO\UserDTO;
use App\Model\User\Exception\UserNotExistsException;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetInfoUserQueryHandler implements MessageHandlerInterface
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetInfoUserQuery $query): UserDTO
    {
        $user = $this->userRepository->findOneById($query->getUserId());
        $userProfile = $this->userProfileRepository->findOneByUserId($query->getUserId());

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