<?php

namespace App\Model\User\Event;

class EditedUserPhoneEvent
{
    private const TYPE = "sync_phone";

    public string $email;
    public string $phone;
    public string $type;

    public function __construct(string $email, string $phone)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->type = self::TYPE;
    }
}
