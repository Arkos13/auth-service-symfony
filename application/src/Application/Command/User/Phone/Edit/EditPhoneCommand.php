<?php

namespace App\Application\Command\User\Phone\Edit;

use App\Application\Command\CommandInterface;

class EditPhoneCommand implements CommandInterface
{
    private string $profileId;
    private string $phone;

    public function __construct(string $profileId, string $phone)
    {
        $this->profileId = $profileId;
        $this->phone = $phone;
    }

    public function getProfileId(): string
    {
        return $this->profileId;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }


}