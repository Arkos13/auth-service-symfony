<?php

namespace App\Tests\Functional\User\Password;

use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class ResendEmailInviteRecoveryPasswordActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/open_api/users/resend_email_invite_recovery_password";

    public function testResendEmailInviteRecoveryPassword(): void
    {
        $body = [
            "email" => "test1@gmail.com",
            "url" => "localhost"
        ];
        $this->client->request("POST", self::ROUTE, $body);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }


}
