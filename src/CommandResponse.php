<?php

namespace Loxodonta\CommandBus;

use Loxodonta\CommandBus\Signature\CommandResponseInterface;

/**
 * Class CommandResponse
 */
class CommandResponse implements CommandResponseInterface
{
    /**
     * @var mixed
     */
    private $value;
    private array $events;

    public function __construct($value, array $events = [])
    {
        $this->value = $value;
        $this->events = $events;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function hasEvents(): bool
    {
        return !empty($this->events);
    }

    /**
     * @inheritDoc
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
