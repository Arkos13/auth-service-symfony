<?php

namespace App\Tests\Application\Command\User;

use App\Application\Command\User\RegistrationViaNetwork\RegistrationViaNetworkCommand;
use App\Infrastructure\Shared\Persistence\DataFixtures\User\UserFixtures;
use App\Model\User\Event\RegisteredUserViaNetworkEvent;
use App\Model\User\Exception\NetworkAlreadyExistsException;
use App\Model\User\Repository\NetworkRepositoryInterface;
use App\Tests\Application\ApplicationTestCase;

class RegistrationViaNetworkCommandHandlerTest extends ApplicationTestCase
{
    public function testNetworkAlreadyExistsException(): void
    {
        $command = new RegistrationViaNetworkCommand(
            UserFixtures::USER_EMAIL_TEST,
            "test",
            "test",
            "google",
            "123",
            "test_token"
        );

        $this->expectException(NetworkAlreadyExistsException::class);

        $this->handle($command);
    }

    public function testUserExists(): void
    {
        /** @var NetworkRepositoryInterface $networkRepository */
        $networkRepository = $this->service(NetworkRepositoryInterface::class);
        $command = new RegistrationViaNetworkCommand(
            UserFixtures::USER_EMAIL_TEST,
            "test",
            "test",
            "facebook",
            "123",
            "test_token"
        );

        $this->handle($command);

        $this->assertNotEmmitEvent();
        $network = $networkRepository->findOneByEmailAndNetwork(
            UserFixtures::USER_EMAIL_TEST,
            "facebook"
        );
        $this->assertNotEmpty($network);
    }

    public function testRegistrationUser(): void
    {
        /** @var NetworkRepositoryInterface $networkRepository */
        $networkRepository = $this->service(NetworkRepositoryInterface::class);
        $command = new RegistrationViaNetworkCommand(
            "test_new@gmail.com",
            "test",
            "test",
            "google",
            "123",
            "test_token"
        );

        $this->handle($command);

        $this->assertEmmitEvent(RegisteredUserViaNetworkEvent::class);
        $network = $networkRepository->findOneByEmailAndNetwork(
            "test_new@gmail.com",
            "google"
        );
        $this->assertNotEmpty($network);
    }
}