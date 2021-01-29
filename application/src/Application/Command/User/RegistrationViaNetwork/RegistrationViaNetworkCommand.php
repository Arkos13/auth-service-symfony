<?php

namespace App\Application\Command\User\RegistrationViaNetwork;

use App\Application\Command\CommandInterface;

/**
 * @psalm-immutable
*/
class RegistrationViaNetworkCommand implements CommandInterface
{
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $network;
    public string $identifier;
    public string $networkAccessToken;

    public function __construct(string $email,
                                string $firstName,
                                string $lastName,
                                string $network,
                                string $identifier,
                                string $networkAccessToken)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->network = $network;
        $this->identifier = $identifier;
        $this->networkAccessToken = $networkAccessToken;
    }


}