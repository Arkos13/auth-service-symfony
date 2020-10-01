<?php

namespace App\Model\User\Event;

class EditedUserEmailEvent
{
    private const TYPE = "sync_email";

    public string $oldEmail;
    public string $email;
    public string $type;

    public function __construct(string $oldEmail, string $email)
    {
        $this->oldEmail = $oldEmail;
        $this->email = $email;
        $this->type = self::TYPE;
    }
}
