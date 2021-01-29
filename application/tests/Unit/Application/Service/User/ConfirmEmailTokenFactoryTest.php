<?php

namespace App\Tests\Unit\Application\Service\User;

use App\Application\Service\User\ConfirmEmailToken\Data;
use App\Model\User\Entity\ConfirmEmailToken;
use App\Model\User\Repository\ConfirmEmailTokenRepositoryInterface;
use App\Application\Service\User\ConfirmEmailToken\ConfirmEmailTokenFactory;
use App\Tests\Builder\User\ConfirmEmailTokenBuilder;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfirmEmailTokenFactoryTest extends TestCase
{
    private MockObject $confirmEmailTokenRepository;
    private ConfirmEmailTokenFactory $confirmEmailTokenFactory;

    public function setUp(): void
    {
        parent::setUp();
        $this->confirmEmailTokenRepository = $this->createMock(ConfirmEmailTokenRepositoryInterface::class);
        $this->confirmEmailTokenFactory = new ConfirmEmailTokenFactory($this->confirmEmailTokenRepository);
    }

    public function testCreateNotExistsToken(): void
    {
        $this->confirmEmailTokenRepository->method("findOneByUserAndEmail")->willReturn(null);
        $token = $this->confirmEmailTokenFactory->create(
            new Data((new UserBuilder())->build(), "testNew@gmail.com")
        );
        $this->assertInstanceOf(ConfirmEmailToken::class, $token);
    }

    public function testCreateExistsToken(): void
    {
        $existsToken = (new ConfirmEmailTokenBuilder("+2 hour"))->build();
        $this->confirmEmailTokenRepository->method("findOneByUserAndEmail")
            ->willReturn($existsToken);
        $token = $this->confirmEmailTokenFactory->create(
            new Data((new UserBuilder())->build(), "testNew@gmail.com")
        );
        $this->assertInstanceOf(ConfirmEmailToken::class, $token);
        $this->assertSame($existsToken, $token);
    }
}
