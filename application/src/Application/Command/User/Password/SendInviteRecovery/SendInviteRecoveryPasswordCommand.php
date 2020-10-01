<?php

namespace App\Application\Command\User\Password\SendInviteRecovery;

class SendInviteRecoveryPasswordCommand
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