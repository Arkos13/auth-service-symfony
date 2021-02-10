<?php

namespace App\Infrastructure\Shared\Messenger\Bus;

use App\Model\Shared\Event\EventBusInterface;
use App\Model\Shared\Event\EventInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
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
     * @param EventInterface ...$events
     * @throws Throwable
     */
    public function handle(EventInterface ...$events): void
    {
        try {
            foreach ($events as $event) {
                $this->eventBus->dispatch(
                    (new Envelope($event))
                        ->with(new DispatchAfterCurrentBusStamp())
                );
            }
        } catch (HandlerFailedException $e) {
            $this->throwPreviousException($e);
        }
    }
}