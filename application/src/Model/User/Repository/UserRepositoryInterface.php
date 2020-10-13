<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\User;

interface UserRepositoryInterface
{
    public function findOneByEmail(string $email): ?User;
    public function findOneByConfirmationToken(string $token): ?User;
    public function findOneById(string $id): ?User;
    public function getOneById(string $id): User;
    public function add(User $user): void;
}
