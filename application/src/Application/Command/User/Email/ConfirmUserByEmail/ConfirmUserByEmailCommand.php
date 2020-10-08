<?php

namespace App\Application\Command\User\Email\ConfirmUserByEmail;

use App\Application\Command\CommandInterface;

class ConfirmUserByEmailCommand implements CommandInterface
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