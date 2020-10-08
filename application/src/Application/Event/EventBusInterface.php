<?php

namespace App\Application\Event;

interface EventBusInterface
{
    public function handle(EventInterface $event): void;
}
