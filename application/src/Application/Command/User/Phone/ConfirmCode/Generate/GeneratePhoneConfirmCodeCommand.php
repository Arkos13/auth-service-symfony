<?php

namespace App\Application\Command\User\Phone\ConfirmCode\Generate;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class GeneratePhoneConfirmCodeCommand implements CommandInterface
{
    public string $userId;
    public string $phone;

    public function __construct(string $userId, string $phone)
    {
        $this->userId = $userId;
        $this->phone = $phone;
    }


}