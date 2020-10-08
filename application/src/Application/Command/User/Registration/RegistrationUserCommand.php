<?php

namespace App\Application\Command\User\Registration;

use App\Application\Command\CommandInterface;

class RegistrationUserCommand implements CommandInterface
{
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $url;
    private string $password;

    public function __construct(string $email,
                                string $firstName,
                                string $lastName,
                                string $url,
                                string $password)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->url = $url;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}