<?php

namespace App\Application\Query\User\GetInfo;

use App\Application\Query\QueryInterface;

/**
 * @psalm-immutable
 */
class GetInfoUserQuery implements QueryInterface
{
    public string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }


}