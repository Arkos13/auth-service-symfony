<?php

namespace App\Tests\Functional\User;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetUserInfoActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/api/users/info";

    public function testGetInfo(): void
    {
        $this->client->request("GET", self::ROUTE, [], [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
