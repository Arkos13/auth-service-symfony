<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\ConfirmPasswordToken;
use App\Model\User\Entity\User;

interface ConfirmPasswordTokenRepositoryInterface
{
    public function findOneByUser(User $user): ?ConfirmPasswordToken;
    public function findOneByToken(string $token): ?ConfirmPasswordToken;
    public function remove(ConfirmPasswordToken $token): void;
    public function add(ConfirmPasswordToken $token): void;
}
