<?php

namespace App\Application\Command\User\Password\SendInviteRecovery;

use App\Application\Command\CommandInterface;

class SendInviteRecoveryPasswordCommand implements CommandInterface
{
    private string $email;
    private string $url;

    public function __construct(string $email, string $url)
    {
        $this->email = $email;
        $this->url = $url;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUrl(): string
    {
        return $this->url;
    }


}