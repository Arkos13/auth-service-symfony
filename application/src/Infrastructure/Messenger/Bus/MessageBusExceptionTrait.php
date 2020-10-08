<?php

namespace App\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Throwable;

trait MessageBusExceptionTrait
{
    /**
     * @param HandlerFailedException $exception
     * @throws Throwable
     */
    public function throwPreviousException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            /** @var Throwable $exception */
            $exception = $exception->getPrevious();
        }
        throw $exception;
    }

}