<?php

namespace App\Application\Command\User\Email\ConfirmUserByEmail;

class ConfirmUserByEmailCommand
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