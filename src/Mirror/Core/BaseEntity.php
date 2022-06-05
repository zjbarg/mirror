<?php

namespace Mirror\Core;

use Mirror\Core\Contracts\DomainEvent;

abstract class BaseEntity
{
    protected array $domain_events = [];

    /**
     * Add an event to be dispatched when the entity is persisted
     */
    protected function raise(DomainEvent $event): void
    {
        array_push($this->domain_events, $event);
    }

    /**
     * @return DomainEvent[]
     */
    public function dequeueDomainEvents(): array
    {
        $events = $this->domain_events;
        $this->domain_events = [];

        return $events;
    }
}
