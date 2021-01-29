<?php

namespace App\Application\Command\User\Profile\Edit;

use App\Application\Command\CommandInterface;
use DateTimeImmutable;

/**
 * @psalm-immutable
 */
class EditUserProfileCommand implements CommandInterface
{
    public string $userId;
    public string $firstName;
    public string $lastName;
    public ?DateTimeImmutable $birthday;
    public ?string $gender;

    public function __construct(string $userId,
                                string $firstName,
                                string $lastName,
                                ?DateTimeImmutable $birthday,
                                ?string $gender)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }


}