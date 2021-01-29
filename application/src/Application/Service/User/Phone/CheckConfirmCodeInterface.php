<?php

namespace App\Application\Service\User\Phone;

interface CheckConfirmCodeInterface
{
    public function checkCode(string $userId, int $code): string;
}
