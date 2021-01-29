<?php

namespace App\Tests\Functional\User\Password;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class RecoveryPasswordActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/users/recovery_password";

    public function testRecoveryPassword(): void
    {
        $body = [
            "password" => "123456",
            "confirmPassword" => "123456"
        ];
        $this->client->request("POST", self::ROUTE . "?token=123", $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidPasswordRecoveryPassword(): void
    {
        $body = [
            "password" => "123456",
            "confirmPassword" => "12345"
        ];
        $this->client->request("POST", self::ROUTE . "?token=123", $body);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

}
