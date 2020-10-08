<?php

namespace App\Application\Query\User\GetInfoByEmail;

use App\Application\Query\QueryInterface;

class GetInfoUserByEmailQuery implements QueryInterface
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