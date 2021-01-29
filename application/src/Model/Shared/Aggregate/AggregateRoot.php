<?php

declare(strict_types=1);

namespace App\Model\Shared\Aggregate;

use App\Model\Shared\Event\EventInterface;

abstract class AggregateRoot
{
    /**
     * @var array<int, EventInterface>
    */
    private array $domainEvents = [];

    /**
     * @return array<int, EventInterface>
     */
    final public function pullDomainEvents(): array
    {
        $domainEvents       = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function apply(EventInterface $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
