<?php

namespace App\Tests\Application;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\CommandInterface;
use App\Application\Query\QueryBusInterface;
use App\Application\Query\QueryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

abstract class ApplicationTestCase extends KernelTestCase
{
    private ?CommandBusInterface $commandBus;
    private ?QueryBusInterface $queryBus;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->commandBus = $this->service(CommandBusInterface::class);
        $this->queryBus = $this->service(QueryBusInterface::class);
    }

    protected function ask(QueryInterface $query)
    {
        return $this->queryBus->ask($query);
    }

    protected function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }

    /**
     * @param string $serviceId
     * @return object|null
     */
    protected function service(string $serviceId)
    {
        return self::$container->get($serviceId);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->commandBus = null;
        $this->queryBus = null;
    }

    protected function assertEmmitEvent(string $eventClass): void
    {
        /** @var InMemoryTransport $transport */
        $transport = $this->service('messenger.transport.event');
        $this->assertCount(1, $transport->get());
        /** @var Envelope $envelope */
        $envelope = $transport->get()[0];
        $this->assertInstanceOf($eventClass, $envelope->getMessage());
    }

    protected function assertEmmitSynchronizeEvent(string $eventClass, string $transportName): void
    {
        /** @var InMemoryTransport $transport */
        $transport = $this->service("messenger.transport.{$transportName}");
        $this->assertCount(1, $transport->get());
        /** @var Envelope $envelope */
        $envelope = $transport->get()[0];
        $this->assertInstanceOf($eventClass, $envelope->getMessage());
    }

    protected function assertNotEmmitEvent(): void
    {
        /** @var InMemoryTransport $transport */
        $transport = $this->service('messenger.transport.event');
        $this->assertCount(0, $transport->get());
    }
}
