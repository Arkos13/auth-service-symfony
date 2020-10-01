<?php

namespace App\Tests\Functional\User;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class CheckExistsActionTest extends BaseFunctionalTestCase
{
    private const EXISTS_EMAIL = "test@gmail.com";
    private const NOT_EXISTS_EMAIL = "test@test.com";
    private const ROUTE = "/open_api/users/check_exists";

    public function testBadRequestCheckExists(): void
    {
        $this->client->request("GET", self::ROUTE);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testTrueCheckExists(): void
    {
        $this->client->request("GET", self::ROUTE . "?email=" . self::EXISTS_EMAIL);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('{"id":"1eaa6f9c-7cba-6e5e-80d9-0242c0a8de04","email":"test@gmail.com","firstName":"First","lastName":"Last"}', $this->client->getResponse()->getContent());
    }

    public function testFalseCheckExists(): void
    {
        $this->client->request("GET", self::ROUTE . "?email=" . self::NOT_EXISTS_EMAIL);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('false', $this->client->getResponse()->getContent());
    }
}
