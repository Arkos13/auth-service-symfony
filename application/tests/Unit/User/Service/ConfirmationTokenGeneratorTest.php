<?php

namespace App\Tests\Unit\User\Service;

use App\Application\Service\User\Token\ConfirmationTokenGenerator;
use App\Model\User\Repository\UserRepositoryInterface;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class ConfirmationTokenGeneratorTest extends TestCase
{
    private ConfirmationTokenGenerator $confirmationTokenGenerator;

    public function setUp(): void
    {
        parent::setUp();
        $repository = $this->createMock(UserRepositoryInterface::class);
        $this->confirmationTokenGenerator = new ConfirmationTokenGenerator($repository);
    }

    public function testGenerateToken(): void
    {
        $token = $this->confirmationTokenGenerator->generateConfirmationToken((new UserBuilder())->build());
        $this->assertIsString($token);
    }
}
