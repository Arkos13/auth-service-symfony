<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Email\SendChangeInvite\SendChangeInviteCommand;
use App\Application\Command\User\Email\SendChangeInvite\SendChangeInviteCommandHandler;
use App\Application\Service\Mail\MailServiceInterface;
use App\Application\Service\User\ConfirmEmailToken\ConfirmEmailTokenFactoryAbstract;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class SendChangeInviteCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulSendInvite(): void
    {
        $command = new SendChangeInviteCommand("test@gmail.com", "test_new@gmail.com", "test");
        $mailService = $this->createMock(MailServiceInterface::class);
        $handler = new SendChangeInviteCommandHandler(
            $mailService,
            $this->service(UserRepositoryInterface::class),
            $this->service(ConfirmEmailTokenFactoryAbstract::class),
        );

        $mailService
            ->expects($this->once())
            ->method("sendEmail")
            ->with("test_new@gmail.com");

        $handler($command);
    }

    public function testUserNotFoundException(): void
    {
        $command = new SendChangeInviteCommand("test_new@gmail.com", "test@gmail.com", "test");

        $this->expectException(EmailInviteException::class);
        $this->expectExceptionMessage("User not found");

        $this->handle($command);
    }

    public function testEmailExistsException(): void
    {
        $command = new SendChangeInviteCommand("test@gmail.com", "test@gmail.com", "test");

        $this->expectException(EmailInviteException::class);
        $this->expectExceptionMessage("This email already exists");

        $this->handle($command);
    }
}