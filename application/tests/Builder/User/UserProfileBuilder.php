<?php

namespace App\Tests\Builder\User;

use App\Model\User\Entity\User;
use App\Model\User\Entity\UserProfile;

class UserProfileBuilder
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): UserProfile
    {
        return UserProfile::create($this->user, 'first', 'last');
    }
}
