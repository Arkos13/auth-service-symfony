<?php

namespace App\Application\Command\User\Phone\Edit;

class EditPhoneCommand
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