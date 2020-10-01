<?php

namespace App\Application\Service\User\Network\OAuth\Fetch;

class FetchUserData
{
    public string $email;
    public string $network;
    public string $accessToken;

    public function __construct(string $email, string $network, string $accessToken)
    {
        $this->email = $email;
        $this->network = $network;
        $this->accessToken = $accessToken;
    }
}
