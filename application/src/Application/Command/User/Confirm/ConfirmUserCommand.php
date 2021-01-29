<?php

namespace App\Application\Command\User\Confirm;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class ConfirmUserCommand implements CommandInterface
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }


}