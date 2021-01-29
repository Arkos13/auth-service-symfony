<?php

namespace App\Model\Shared\Event;

interface EventBusInterface
{
    public function handle(EventInterface ...$events): void;
}
