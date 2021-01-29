<?php

namespace App\Model\User\Event;

use App\Model\Shared\Event\EventInterface;

/**
 * @psalm-immutable
*/
class ChangedPasswordEvent implements EventInterface
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }


}