<?php

namespace App\Tests\Unit\Application\Service\User;

use App\Application\Service\User\ConfirmPasswordToken\ConfirmPasswordTokenFactory;
use App\Model\User\Entity\ConfirmPasswordToken;
use App\Model\User\Repository\ConfirmPasswordTokenRepositoryInterface;
use App\Tests\Builder\User\ConfirmPasswordTokenBuilder;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfirmPasswordTokenFactoryTest extends TestCase
{
    private MockObject $confirmTokenRepository;
    private ConfirmPasswordTokenFactory $confirmEmailTokenFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->confirmTokenRepository = $this->createMock(ConfirmPasswordTokenRepositoryInterface::class);
        $this->confirmEmailTokenFactory = new ConfirmPasswordTokenFactory(
            $this->confirmTokenRepository
        );
    }

    public function testCreateNotExistsToken(): void
    {
        $this->confirmTokenRepository->method("findOneByUser")->willReturn(null);

        $token = $this->confirmEmailTokenFactory->create((new UserBuilder())->build());

        $this->assertInstanceOf(ConfirmPasswordToken::class, $token);
    }

    public function testCreateExistsToken(): void
    {
        $existsToken = (new ConfirmPasswordTokenBuilder("+2 hour"))->build();
        $this->confirmTokenRepository->method("findOneByUser")->willReturn($existsToken);

        $token = $this->confirmEmailTokenFactory->create((new UserBuilder())->build());

        $this->assertInstanceOf(ConfirmPasswordToken::class, $token);
        $this->assertSame($existsToken, $token);
    }
}
