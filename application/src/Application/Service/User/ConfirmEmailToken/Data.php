<?php

namespace App\Application\Service\User\ConfirmEmailToken;

use App\Model\User\Entity\User;

class Data
{
    public User $user;
    public string $newEmail;

    public function __construct(User $user, string $newEmail)
    {
        $this->user = $user;
        $this->newEmail = $newEmail;
    }
}
