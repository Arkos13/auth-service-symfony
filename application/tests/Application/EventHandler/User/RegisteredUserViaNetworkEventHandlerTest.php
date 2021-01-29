<?php

namespace App\Tests\Application\EventHandler\User;

use App\Application\EventHandler\User\RegisteredViaNetwork\RegisteredUserViaNetworkEventHandler;
use App\Application\Service\Mail\MailServiceInterface;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Event\RegisteredUserViaNetworkEvent;
use App\Tests\Application\ApplicationTestCase;

class RegisteredUserViaNetworkEventHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulInvoke(): void
    {
        $event = new RegisteredUserViaNetworkEvent(UserFixtures::USER_EMAIL_TEST, "test");
        $mailService = $this->createMock(MailServiceInterface::class);
        $handler = new RegisteredUserViaNetworkEventHandler($mailService);

        $mailService
            ->expects($this->once())
            ->method("sendEmail")
            ->with(UserFixtures::USER_EMAIL_TEST);

        $handler($event);
    }
}