<?php

namespace App\Application\Command\User\RegistrationViaNetwork;

class RegistrationViaNetworkCommand
{
    private string $email;
    private string $firstName;
    private string $lastName;
    private string $network;
    private string $identifier;
    private string $networkAccessToken;

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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getNetworkAccessToken(): string
    {
        return $this->networkAccessToken;
    }


}