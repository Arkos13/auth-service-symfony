<?php

namespace App\Tests\Functional\User\Profile;

use App\Model\User\Entity\UserProfile;
use App\Tests\Functional\BaseFunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class EditProfileActionTest extends BaseFunctionalTestCase
{
    private const ROUTE = "/api/users/profile";

    public function testEdit(): void
    {
        $params = [
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'birthday' => '1990-02-02',
            'gender' => UserProfile::GENDER_MALE,
        ];
        $this->client->request("PUT", self::ROUTE, $params, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testInvalidGender(): void
    {
        $params = [
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'birthday' => '1990-02-02',
            'gender' => 'test',
        ];
        $this->client->request("PUT", self::ROUTE, $params, [], $this->getHeadersToken());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }
}
