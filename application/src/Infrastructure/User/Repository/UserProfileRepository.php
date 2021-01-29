<?php

namespace App\Infrastructure\User\Repository;

use App\Model\User\Entity\UserProfile;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findOneByUserId(string $userId): ?UserProfile
    {
        return $this->em
            ->getRepository(UserProfile::class)
            ->findOneBy(["user" => $userId]);
    }

    public function findOneByPhone(string $phone): ?UserProfile
    {
        return $this->em
            ->getRepository(UserProfile::class)
            ->findOneBy(["phone" => $phone]);
    }

    /**
     * @param string $userId
     * @return UserProfile
     * @throws EntityNotFoundException
     */
    public function getOneByUserId(string $userId): UserProfile
    {
        if (!($userProfile = $this->findOneByUserId($userId))) {
            throw new EntityNotFoundException("User profile not found");
        }

        return $userProfile;
    }
}
