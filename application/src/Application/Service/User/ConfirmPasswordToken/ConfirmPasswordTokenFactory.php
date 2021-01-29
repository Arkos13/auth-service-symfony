<?php

namespace App\Application\Service\User\ConfirmPasswordToken;

use App\Model\User\Entity\ConfirmPasswordToken;
use App\Model\User\Entity\User;
use DateTimeImmutable;

class ConfirmPasswordTokenFactory extends ConfirmPasswordTokenFactoryAbstract
{
    private const EXPIRES = "+2 hour";

    protected function make(User $user): ConfirmPasswordToken
    {
        return ConfirmPasswordToken::create(
            $user,
            $this->generateToken(),
            (new DateTimeImmutable())->modify(self::EXPIRES)
        );
    }

    protected function checkExistsConfirmToken(User $user): ?ConfirmPasswordToken
    {
        return $this->repository->findOneByUser($user);
    }
}
