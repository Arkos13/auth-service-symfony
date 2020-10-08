<?php

namespace App\Application\Command\User\Confirm;

use App\Application\Command\CommandInterface;

class ConfirmUserCommand implements CommandInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }


}