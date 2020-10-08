<?php

namespace App\Application\Command\User\Phone\ConfirmCode\Generate;

use App\Application\Command\CommandInterface;

class GeneratePhoneConfirmCodeCommand implements CommandInterface
{
    private string $userId;
    private string $phone;

    public function __construct(string $userId, string $phone)
    {
        $this->userId = $userId;
        $this->phone = $phone;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }


}