<?php

namespace App\Tests\Builder\User;

use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Entity\User;
use DateTimeImmutable;

class ConfirmEmailTokenBuilder
{
    private User $user;
    private DateTimeImmutable $expires;

    public function __construct(string $expires)
    {
        $this->user = (new UserBuilder())->build();
        $this->expires = (new DateTimeImmutable())->modify($expires);
    }

    public function build(): ConfirmEmailToken
    {
        return ConfirmEmailToken::create(
            $this->user,
            "test@gmail.com",
            "token",
            $this->expires
        );
    }
}
