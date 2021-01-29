<?php

namespace App\Model\OAuth\Repository;

interface TokenRepositoryInterface
{
    public function revokeByAccessTokenId(string $id): void;
}