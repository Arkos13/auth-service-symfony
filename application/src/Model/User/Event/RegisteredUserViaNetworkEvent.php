<?php

namespace App\Model\User\Event;

use App\Model\Shared\Event\EventInterface;

/**
 * @psalm-immutable
 */
class RegisteredUserViaNetworkEvent implements EventInterface
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }


}