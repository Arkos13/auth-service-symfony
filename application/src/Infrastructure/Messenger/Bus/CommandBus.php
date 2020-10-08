<?php

namespace App\Infrastructure\Messenger\Bus;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\CommandInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class CommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param CommandInterface $command
     * @return mixed
     * @throws Throwable
     */
    public function handle(CommandInterface $command)
    {
        try {
            $envelope = $this->commandBus->dispatch($command);

            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            if ($stamp->getResult()) {
                return $stamp->getResult();
            }

            return true;
        } catch (HandlerFailedException $e) {
            $this->throwPreviousException($e);
        }
    }
}