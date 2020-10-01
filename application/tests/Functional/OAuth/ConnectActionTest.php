<?php

namespace App\Tests\Functional\OAuth;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class ConnectActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/networks/connect";

    public function testNetworksConnect()
    {
        $body = [
            "email" => "test@gmail.com",
            "firstName" => "firstName",
            "lastName" => "lastName",
            "id" => "123",
            "networkAccessToken" => "test",
            "provider" => "google",
            "client_id" => "61bba35dbf85fcb8cf07f8c80209fbf5",
            "client_secret" => "5fdf5f673438aae9c92b5e567e81ffeb80d78a9e696c4d1915f41c621cad418b379b5e156912f5114c3f76811f94093d62f24bb9ba05b78073ac3ed258755e9e",
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidTokenNetworksConnect()
    {
        $body = [
            "email" => "test@gmail.com",
            "firstName" => "firstName",
            "lastName" => "lastName",
            "id" => "123",
            "networkAccessToken" => "exception",
            "provider" => "google",
            "client_id" => "61bba35dbf85fcb8cf07f8c80209fbf5",
            "client_secret" => "5fdf5f673438aae9c92b5e567e81ffeb80d78a9e696c4d1915f41c621cad418b379b5e156912f5114c3f76811f94093d62f24bb9ba05b78073ac3ed258755e9e",
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testRegistrationNetworksConnect()
    {
        $body = [
            "email" => "testest@gmail.com",
            "firstName" => "firstName",
            "lastName" => "lastName",
            "id" => "123",
            "networkAccessToken" => "test123",
            "provider" => "google",
            "client_id" => "61bba35dbf85fcb8cf07f8c80209fbf5",
            "client_secret" => "5fdf5f673438aae9c92b5e567e81ffeb80d78a9e696c4d1915f41c621cad418b379b5e156912f5114c3f76811f94093d62f24bb9ba05b78073ac3ed258755e9e",
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
