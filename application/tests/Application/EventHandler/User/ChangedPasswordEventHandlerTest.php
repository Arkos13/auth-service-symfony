<?php

namespace App\Tests\Application\EventHandler\User;

use App\Application\EventHandler\User\ChangedPassword\ChangedPasswordEventHandler;
use App\Application\Service\Mail\MailServiceInterface;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Event\ChangedPasswordEvent;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class ChangedPasswordEventHandlerTest extends ApplicationTestCase
{
    public function testEmailInviteException(): void
    {
        $event = new ChangedPasswordEvent("test_new@gmail.com");
        $handler = new ChangedPasswordEventHandler(
            $this->service(MailServiceInterface::class),
            $this->service(UserRepositoryInterface::class),
        );

        $this->expectException(EmailInviteException::class);

        $handler($event);
    }

    public function testSuccessfulInvoke(): void
    {
        $event = new ChangedPasswordEvent(UserFixtures::USER_EMAIL_TEST);
        $mailService = $this->createMock(MailServiceInterface::class);
        $handler = new ChangedPasswordEventHandler(
            $mailService,
            $this->service(UserRepositoryInterface::class)
        );

        $mailService
            ->expects($this->once())
            ->method("sendEmail")
            ->with(UserFixtures::USER_EMAIL_TEST);

        $handler($event);
    }
}