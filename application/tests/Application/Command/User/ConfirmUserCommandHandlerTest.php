<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Confirm\ConfirmUserCommand;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Exception\UserConfirmationTokenNotFoundException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class ConfirmUserCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulConfirm(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->service(UserRepositoryInterface::class);
        $command = new ConfirmUserCommand(UserFixtures::USER_CONFIRM_TOKEN_2);

        $this->handle($command);

        $user = $userRepository->findOneByEmail(UserFixtures::USER_EMAIL_TEST_2);
        $this->assertNotEmpty($user);
        $this->assertNull($user->confirmationToken);
        $this->assertNull($user->expiresConfirmationToken);
    }

    public function testConfirmationTokenNotFoundException(): void
    {
        $command = new ConfirmUserCommand("test");

        $this->expectException(UserConfirmationTokenNotFoundException::class);

        $this->handle($command);
    }

    public function testTokenExpiredException(): void
    {
        $command = new ConfirmUserCommand(UserFixtures::USER_CONFIRM_TOKEN_3);

        $this->expectException(TokenExpiredException::class);

        $this->handle($command);
    }
}