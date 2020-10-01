<?php

namespace App\Tests\Functional\User;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegistrationActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/users/registration";

    public function testRegistration(): void
    {
        $body = [
            "email" => "test2@gmail.com",
            "firstName" => "firstName",
            "lastName" => "lastName",
            "url" => "localhost",
            "password" => "123456",
            "confirmPassword" => "123456"
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidEmailRegistration(): void
    {
        $body = [
            "email" => "test@gmail.com",
            "firstName" => "firstName",
            "lastName" => "lastName",
            "url" => "localhost",
            "password" => "123456",
            "confirmPassword" => "123456"
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidPasswordRegistration(): void
    {
        $body = [
            "email" => "test2@gmail.com",
            "firstName" => "firstName",
            "lastName" => "lastName",
            "url" => "localhost",
            "password" => "123456",
            "confirmPassword" => "123455"
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

}
