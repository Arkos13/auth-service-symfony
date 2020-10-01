<?php

namespace App\Tests\Functional\User\Phone;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class GenerateConfirmCodeActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/api/users/phones/generate_confirm_code";

    public function testGenerateCode(): void
    {
        $body = [
            "phone" => "1234560",
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidPhoneGenerateCode(): void
    {
        $body = [
            "phone" => "1234567",
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

}
