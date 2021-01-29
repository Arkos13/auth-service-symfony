<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\Registration\RegistrationUserCommand;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Event\RegisteredUserEvent;
use App\Model\User\Exception\EmailExistsException;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class RegistrationUserCommandHandlerTest extends ApplicationTestCase
{
    public function testSuccessfulRegistration(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->service(UserRepositoryInterface::class);
        $command = new RegistrationUserCommand(
            "test_new@gmail.com",
            "Test",
            "Test",
            "test",
        );

        $this->handle($command);

        $user = $userRepository->findOneByEmail("test_new@gmail.com");
        $this->assertNotEmpty($user);
        $this->assertEmmitEvent(RegisteredUserEvent::class);
    }

    public function testEmailExistsException(): void
    {
        $command = new RegistrationUserCommand(
            UserFixtures::USER_EMAIL_TEST,
            "Test",
            "Test",
            "test",
        );

        $this->expectException(EmailExistsException::class);

        $this->handle($command);
    }
}