<?php

namespace App\Application\Command\User\Confirm;

class ConfirmUserCommand
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