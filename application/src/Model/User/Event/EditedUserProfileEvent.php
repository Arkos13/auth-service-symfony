<?php

namespace App\Model\User\Event;

use App\Application\Event\EventInterface;

class EditedUserProfileEvent implements EventInterface
{
    private const TYPE = "sync_user_profile";

    public string $email;
    public string $firstName;
    public string $lastName;
    public string $gender;
    public string $birthday;
    public string $type;

    public function __construct(string $email,
                                string $firstName,
                                string $lastName,
                                ?string $gender,
                                ?string $birthday)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender ?? "";
        $this->birthday = $birthday ?? "";
        $this->type = self::TYPE;
    }


}
