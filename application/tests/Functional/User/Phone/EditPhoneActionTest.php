<?php

namespace App\Tests\Functional\User\Phone;

use App\Infrastructure\Shared\Persistence\DataFixtures\User\PhoneConfirmCodeFixtures;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class EditPhoneActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/api/users/" . UserFixtures::USER_ID_TEST . "/phones/edit";

    public function testEditPhone(): void
    {
        $body = [
            "code" => PhoneConfirmCodeFixtures::CODE_TEST,
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testNotExistsToken(): void
    {
        $body = [
            "code" => "4444",
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidToken(): void
    {
        $body = [
            "code" => PhoneConfirmCodeFixtures::CODE_TEST_INVALID,
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }
}
