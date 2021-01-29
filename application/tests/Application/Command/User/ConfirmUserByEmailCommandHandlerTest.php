<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Email\ConfirmUserByEmail\ConfirmUserByEmailCommand;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\ConfirmEmailTokenFixtures;
use App\Model\User\Event\EditedUserEmailEvent;
use App\Model\User\Exception\ConfirmEmailTokenNotFoundException;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class ConfirmUserByEmailCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulConfirm(): void
    {
        /** @var ConfirmEmailTokenRepositoryInterface $confirmEmailTokenRepository */
        $confirmEmailTokenRepository = $this->service(ConfirmEmailTokenRepositoryInterface::class);
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->service(UserRepositoryInterface::class);
        $command = new ConfirmUserByEmailCommand(ConfirmEmailTokenFixtures::TOKEN_TEST);

        $this->handle($command);

        $token = $confirmEmailTokenRepository->findOneByToken(ConfirmEmailTokenFixtures::TOKEN_TEST);
        $this->assertEmpty($token);
        $this->assertEmmitSynchronizeEvent(EditedUserEmailEvent::class, "synchronize_email");
        $user = $userRepository->findOneByEmail(ConfirmEmailTokenFixtures::EMAIL_TEST);
        $this->assertNotEmpty($user);
    }

    public function testConfirmEmailTokenNotFoundException(): void
    {
        $command = new ConfirmUserByEmailCommand("test");

        $this->expectException(ConfirmEmailTokenNotFoundException::class);

        $this->handle($command);
    }

    public function testTokenExpiredException(): void
    {
        $command = new ConfirmUserByEmailCommand(ConfirmEmailTokenFixtures::TOKEN_INVALID_TEST);

        $this->expectException(TokenExpiredException::class);

        $this->handle($command);
    }
}