<?php

namespace App\Infrastructure\User\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface
{
    private string $id;
    private string $username;
    private string $password;
    private ?string $confirmationToken;

    private function __construct(string $id, string $username, string $password, ?string $confirmationToken)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->confirmationToken = $confirmationToken;
    }

    public static function create(string $id,
                                  string $username,
                                  string $password,
                                  ?string $confirmationToken): UserIdentity
    {
        return new UserIdentity($id, $username, $password, $confirmationToken);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }


}