<?php

namespace App\Infrastructure\Shared\Messenger\Middleware;

use App\Model\Shared\Event\DomainEvents;
use App\Model\Shared\Event\EventBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class PullDomainEventsMiddleware implements MiddlewareInterface
{
    private EventBusInterface $eventBus;

    public function __construct(EventBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        $this->eventBus->handle(...DomainEvents::pullDomainEvents());

        return $envelope;
    }
}