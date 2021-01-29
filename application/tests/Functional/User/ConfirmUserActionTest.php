<?php

namespace App\Tests\Functional\User;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class ConfirmUserActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/users/confirm";

    public function testUserConfirm(): void
    {
        $this->client->request("POST", self::ROUTE . "?token=123");
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

}
