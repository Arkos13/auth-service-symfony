<?php

namespace App\Tests\Functional\User\Email;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class SendChangeEmailInviteActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/api/users/email/send_change_email_invite";

    public function testSendChangeEmailInvite(): void
    {
        $body = [
            "email" => "test2@gmail.com",
            "url" => "localhost"
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAlreadyExistsSendChangeEmailInvite(): void
    {
        $body = [
            "email" => "test@gmail.com",
            "url" => "localhost"
        ];
        $this->client->request("POST", self::ROUTE, $body, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }
}
