<?php

namespace App\Application\Query\User\GetInfoByEmail;

class GetInfoUserByEmailQuery
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }


}