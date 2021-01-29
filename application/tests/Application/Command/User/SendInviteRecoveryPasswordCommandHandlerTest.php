<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Password\SendInviteRecovery\SendInviteRecoveryPasswordCommand;
use App\Application\Command\User\Password\SendInviteRecovery\SendInviteRecoveryPasswordCommandHandler;
use App\Application\Service\Mail\MailServiceInterface;
use App\Application\Service\User\ConfirmPasswordToken\ConfirmPasswordTokenFactoryAbstract;
use App\Model\User\Exception\EmailInviteException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class SendInviteRecoveryPasswordCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulSendInvite(): void
    {
        $command = new SendInviteRecoveryPasswordCommand("test@gmail.com", "test");
        $mailService = $this->createMock(MailServiceInterface::class);
        $handler = new SendInviteRecoveryPasswordCommandHandler(
            $this->service(UserRepositoryInterface::class),
            $this->service(ConfirmPasswordTokenFactoryAbstract::class),
            $mailService,
        );

        $mailService
            ->expects($this->once())
            ->method("sendEmail")
            ->with("test@gmail.com");

        $handler($command);
    }

    public function testUserNotFoundException(): void
    {
        $command = new SendInviteRecoveryPasswordCommand("test_new@gmail.com", "test");

        $this->expectException(EmailInviteException::class);
        $this->expectExceptionMessage("User not found");

        $this->handle($command);
    }


}