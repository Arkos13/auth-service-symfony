<?php

namespace App\Model\User\Event;

use App\Application\Event\EventInterface;
use App\Model\User\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserAuthenticatedHistoryEvent extends Event implements EventInterface
{
    const NAME = "user.authenticated.history";

    private User $user;
    private string $ip;
    private ?string $guid;

    public function __construct(User $user, string $ip, ?string $guid)
    {
        $this->user = $user;
        $this->ip = $ip;
        $this->guid = $guid;
    }

    public function getUser(): User
    {
        return $this->user;
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
