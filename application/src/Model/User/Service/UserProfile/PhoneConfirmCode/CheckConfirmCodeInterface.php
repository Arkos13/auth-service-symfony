<?php

namespace App\Model\User\Service\UserProfile\PhoneConfirmCode;

use App\Model\User\Entity\User;

interface CheckConfirmCodeInterface
{
    public function checkCode(User $user, int $code): string;
}
