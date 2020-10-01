<?php

namespace App\Tests\Builder\User;

use App\Model\User\Entity\User;
use DateTimeImmutable;

class UserBuilder
{
    private string $email;
    private ?DateTimeImmutable $expiresToken;

    public function __construct()
    {
        $this->email = "test@gmail.com";
        $this->expiresToken = null;
    }

    public function setExpiresToken(string $expires): self
    {
        $this->expiresToken = (new DateTimeImmutable())->modify($expires);
        return $this;
    }

    public function build(): User
    {
        $user = User::create($this->email, '');
        $user->setExpiresConfirmationToken($this->expiresToken);
        return $user;
    }
}
