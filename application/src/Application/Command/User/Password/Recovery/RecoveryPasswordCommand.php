<?php

namespace App\Application\Command\User\Password\Recovery;

use App\Application\Command\CommandInterface;

class RecoveryPasswordCommand implements CommandInterface
{
    private string $confirmationToken;
    private string $password;

    public function __construct(string $confirmationToken,
                                string $password)
    {
        $this->confirmationToken = $confirmationToken;
        $this->password = $password;
    }

    public function getConfirmationToken(): string
    {
        return $this->confirmationToken;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}