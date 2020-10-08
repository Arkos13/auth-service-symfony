<?php

namespace App\Application\Query\User\GetInfo;

use App\Application\Query\QueryInterface;

class GetInfoUserQuery implements QueryInterface
{
    private string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }


}