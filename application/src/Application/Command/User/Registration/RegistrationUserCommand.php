<?php

namespace App\Application\Command\User\Registration;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class RegistrationUserCommand implements CommandInterface
{
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $password;

    public function __construct(string $email,
                                string $firstName,
                                string $lastName,
                                string $password)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
    }


}