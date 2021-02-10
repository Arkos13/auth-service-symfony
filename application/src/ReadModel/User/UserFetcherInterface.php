<?php

namespace App\ReadModel\User;

interface UserFetcherInterface
{
    public function findForAuthByEmail(string $email): ?UserAuthDTO;
}