<?php

namespace App\Application\Command\User\Phone\Edit;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
 */
class EditPhoneCommand implements CommandInterface
{
    public string $profileId;
    public string $phone;

    public function __construct(string $profileId, string $phone)
    {
        $this->profileId = $profileId;
        $this->phone = $phone;
    }


}