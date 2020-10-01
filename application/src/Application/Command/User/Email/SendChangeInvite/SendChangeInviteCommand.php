<?php

namespace App\Application\Command\User\Email\SendChangeInvite;

class SendChangeInviteCommand
{
    private string $email;
    private string $newEmail;
    private string $url;

    public function __construct(string $email, string $newEmail, string $url)
    {
        $this->email = $email;
        $this->newEmail = $newEmail;
        $this->url = $url;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNewEmail(): string
    {
        return $this->newEmail;
    }

    public function getUrl(): string
    {
        return $this->url;
    }


}