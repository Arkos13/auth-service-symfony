<?php

namespace App\Infrastructure\Messenger\Bus;

use App\Application\Event\EventBusInterface;
use App\Application\Event\EventInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class EventBus implements EventBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param EventInterface $event
     * @throws Throwable
     */
    public function handle(EventInterface $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            $this->throwPreviousException($e);
        }
    }
}