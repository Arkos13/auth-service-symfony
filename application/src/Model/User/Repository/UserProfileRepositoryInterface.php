<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\UserProfile;

interface UserProfileRepositoryInterface
{
    public function findOneByUserId(string $userId): ?UserProfile;
    public function findOneByPhone(string $phone): ?UserProfile;
    public function add(UserProfile $userProfile): void;
}
