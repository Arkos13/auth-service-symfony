<?php

namespace App\Model\Shared\Event;

class DomainEvents
{
    /**
     * @var array<int, EventInterface>
     */
    private static array $domainEvents = [];

    /**
     * @return array<int, EventInterface>
     */
    final public static function pullDomainEvents(): array
    {
        $domainEvents       = DomainEvents::$domainEvents;
        DomainEvents::$domainEvents = [];

        return $domainEvents;
    }

    final public static function apply(EventInterface $domainEvent): void
    {
        DomainEvents::$domainEvents[] = $domainEvent;
    }
}