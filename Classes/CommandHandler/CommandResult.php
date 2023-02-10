<?php

namespace WebSupply\Commander\CommandHandler;

use Neos\Flow\Annotations as Flow;
use WebSupply\EventDispatcher\EventDispatcher\EventsToDispatch;

#[Flow\Proxy(false)]
final class CommandResult
{
    public EventsToDispatch $events;

    protected function __construct() {
        $this->events = EventsToDispatch::empty();
    }

    public static function create(): self
    {
        return new self();
    }

    public function raiseEvent(object $event): self
    {
        $this->events->append($event);
        return $this;
    }
}
