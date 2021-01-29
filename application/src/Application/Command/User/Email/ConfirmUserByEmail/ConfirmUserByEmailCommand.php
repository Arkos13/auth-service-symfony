<?php

namespace App\Application\Command\User\Email\ConfirmUserByEmail;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class ConfirmUserByEmailCommand implements CommandInterface
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }


}