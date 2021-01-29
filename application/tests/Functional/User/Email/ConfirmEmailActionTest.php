<?php

namespace App\Tests\Functional\User\Email;

use App\Infrastructure\Shared\Persistence\DataFixtures\User\ConfirmEmailTokenFixtures;
use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class ConfirmEmailActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/users/email/confirm";

    public function testConfirmEmail(): void
    {
        $body = [
            "token" => ConfirmEmailTokenFixtures::TOKEN_TEST,
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


}
