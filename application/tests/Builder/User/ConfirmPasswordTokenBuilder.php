<?php

namespace App\Tests\Builder\User;

use App\Model\User\Entity\ConfirmPasswordToken;
use App\Model\User\Entity\User;
use DateTimeImmutable;

class ConfirmPasswordTokenBuilder
{
    private User $user;
    private DateTimeImmutable $expires;

    public function __construct(string $expires)
    {
        $this->user = (new UserBuilder())->build();
        $this->expires = (new DateTimeImmutable())->modify($expires);
    }

    public function build(): ConfirmPasswordToken
    {
        return ConfirmPasswordToken::create(
            $this->user,
            "token",
            $this->expires
        );
    }
}
