<?php

namespace App\Infrastructure\Messenger\Bus;

use App\Application\Query\QueryBusInterface;
use App\Application\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class QueryBus implements QueryBusInterface
{
    use HandleTrait;
    use MessageBusExceptionTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     * @throws Throwable
     */
    public function ask(QueryInterface $query)
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $e) {
            $this->throwPreviousException($e);
        }
    }
}