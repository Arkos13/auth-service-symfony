<?php

namespace App\Application\Service\OAuth\Client\Registry;

use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry as KnpUClientRegistry;

class ClientRegistry implements ClientRegistryInterface
{
    private KnpUClientRegistry $clientRegistry;

    public function __construct(KnpUClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
    }

    public function getClient(string $network): OAuth2ClientInterface
    {
        return $this->clientRegistry->getClient($network);
    }
}
