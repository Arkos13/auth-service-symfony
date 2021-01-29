<?php

namespace App\Tests\Application\EventHandler\User;

use App\Application\EventHandler\User\Registered\RegisteredUserEventHandler;
use App\Application\Service\Mail\MailServiceInterface;
use App\Application\Service\User\Token\TokenGeneratorInterface;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Event\RegisteredUserEvent;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserProfileRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class RegisteredUserEventHandlerTest extends ApplicationTestCase
{
    public function testEmailInviteException(): void
    {
        $event = new RegisteredUserEvent("test_new@gmail.com");
        $handler = new RegisteredUserEventHandler(
            $this->service(MailServiceInterface::class),
            $this->service(UserRepositoryInterface::class),
            $this->service(UserProfileRepositoryInterface::class),
            $this->service(TokenGeneratorInterface::class),
        );

        $this->expectException(EmailInviteException::class);

        $handler($event);
    }

    public function testSuccessfulInvoke(): void
    {
        $event = new RegisteredUserEvent(UserFixtures::USER_EMAIL_TEST);
        $mailService = $this->createMock(MailServiceInterface::class);
        $handler = new RegisteredUserEventHandler(
            $mailService,
            $this->service(UserRepositoryInterface::class),
            $this->service(UserProfileRepositoryInterface::class),
            $this->service(TokenGeneratorInterface::class),
        );

        $mailService
            ->expects($this->once())
            ->method("sendEmail")
            ->with(UserFixtures::USER_EMAIL_TEST);

        $handler($event);
    }
}