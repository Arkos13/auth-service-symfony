<?php

namespace App\Model\User\Repository;

use App\Model\User\Entity\PhoneConfirmCode;

interface PhoneConfirmCodeRepositoryInterface
{
    public function findOneByUserIdAndCode(string $userId, int $code): ?PhoneConfirmCode;
    public function remove(PhoneConfirmCode $code): void;
    public function add(PhoneConfirmCode $code): void;
}
