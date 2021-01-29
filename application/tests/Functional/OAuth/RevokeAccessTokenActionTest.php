<?php

namespace App\Tests\Functional\OAuth;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class RevokeAccessTokenActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/api/token/revoke";

    public function testNetworksConnect()
    {
        $this->client->request("POST", self::ROUTE, [], [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->client->request("POST", self::ROUTE, [], [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $this->client->getResponse()->getStatusCode());
    }
}
