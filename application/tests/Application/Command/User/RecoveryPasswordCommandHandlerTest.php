<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Password\Recovery\RecoveryPasswordCommand;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\ConfirmPasswordTokenFixtures;
use App\Model\User\Event\ChangedPasswordEvent;
use App\Model\User\Exception\ConfirmPasswordTokenNotFoundException;
use App\Model\User\Exception\TokenExpiredException;
use App\Model\User\Repository\ConfirmPasswordTokenRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class RecoveryPasswordCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulRecovery(): void
    {
        /** @var ConfirmPasswordTokenRepositoryInterface $tokenRepository */
        $tokenRepository = $this->service(ConfirmPasswordTokenRepositoryInterface::class);
        $command = new RecoveryPasswordCommand(
            ConfirmPasswordTokenFixtures::VALID_TOKEN,
            "test"
        );

        $this->handle($command);

        $token = $tokenRepository->findOneByToken(ConfirmPasswordTokenFixtures::VALID_TOKEN);
        $this->assertEmpty($token);
        $this->assertEmmitEvent(ChangedPasswordEvent::class);
    }

    public function testConfirmPasswordTokenNotFoundException(): void
    {
        $command = new RecoveryPasswordCommand(
            "test",
            "test"
        );

        $this->expectException(ConfirmPasswordTokenNotFoundException::class);

        $this->handle($command);
    }

    public function testTokenExpiredException(): void
    {
        $command = new RecoveryPasswordCommand(
            ConfirmPasswordTokenFixtures::INVALID_TOKEN,
            "test"
        );

        $this->expectException(TokenExpiredException::class);

        $this->handle($command);
    }
}