<?php

namespace App\Application\Query\User\GetInfoByEmail;

use App\Application\Query\QueryInterface;

/**
 * @psalm-immutable
 */
class GetInfoUserByEmailQuery implements QueryInterface
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }


}