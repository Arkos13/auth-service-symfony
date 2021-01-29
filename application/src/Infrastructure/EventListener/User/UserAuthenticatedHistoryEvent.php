<?php

namespace App\Infrastructure\EventListener\User;

use Symfony\Contracts\EventDispatcher\Event;

class UserAuthenticatedHistoryEvent extends Event
{
    const NAME = "user.authenticated.history";

    private string $email;
    private string $ip;
    private ?string $guid;

    public function __construct(string $email, string $ip, ?string $guid)
    {
        $this->email = $email;
        $this->ip = $ip;
        $this->guid = $guid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }
}
