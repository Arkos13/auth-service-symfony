<?php

namespace App\Application\Command\User\Profile\Edit;

use DateTimeImmutable;

class EditUserProfileCommand
{
    private string $userId;
    private string $firstName;
    private string $lastName;
    private ?DateTimeImmutable $birthday;
    private ?string $gender;

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

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthday(): ?DateTimeImmutable
    {
        return $this->birthday;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }


}