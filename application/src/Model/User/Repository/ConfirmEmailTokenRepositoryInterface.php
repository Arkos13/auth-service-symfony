<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Entity\User;

interface ConfirmEmailTokenRepositoryInterface
{
    public function findOneByUserAndEmail(User $user, string $email): ?ConfirmEmailToken;
    public function findOneByToken(string $token): ?ConfirmEmailToken;
    public function remove(ConfirmEmailToken $token): void;
    public function add(ConfirmEmailToken $token): void;
}
