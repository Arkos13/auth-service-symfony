<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseFunctionalTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected array $headers = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function getHeadersToken(): array
    {
        $this->headers = [
            'HTTP_AUTHORIZATION' => "Bearer {$_ENV["ACCESS_TOKEN"]}",
            'CONTENT_TYPE' => 'application/json',
        ];
        return $this->headers;
    }
}
