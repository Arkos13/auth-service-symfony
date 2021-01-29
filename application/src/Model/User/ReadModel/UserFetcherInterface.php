<?php

namespace App\Model\User\ReadModel;

interface UserFetcherInterface
{
    public function findForAuthByEmail(string $email): ?UserAuthDTO;
}