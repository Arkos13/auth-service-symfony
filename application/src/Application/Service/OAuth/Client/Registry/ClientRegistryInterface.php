<?php

namespace App\Application\Service\OAuth\Client\Registry;

use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;

interface ClientRegistryInterface
{
    public function getClient(string $network): OAuth2ClientInterface;
}
