<?php

namespace App\Application\Event\User\Registered;

use App\Application\Event\EventInterface;

class RegisteredUserEvent implements EventInterface
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