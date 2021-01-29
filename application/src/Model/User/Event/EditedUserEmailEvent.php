<?php

namespace App\Model\User\Event;

use App\Model\Shared\Event\EventInterface;

/**
 * @psalm-immutable
 */
class EditedUserEmailEvent implements EventInterface
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
