<?php

namespace App\Tests\Functional\User\Email;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class ConfirmEmailActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/users/email/confirm";

    public function testConfirmEmail(): void
    {
        $body = [
            "token" => "123",
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidTokenConfirmEmail(): void
    {
        $body = [
            "token" => "1234",
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }
}
