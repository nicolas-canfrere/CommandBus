<?php

namespace Loxodonta\CommandBus\Signature;

/**
 * Interface CommandResponseInterface
 */
interface CommandResponseInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return bool
     */
    public function hasEvents(): bool;

    /**
     * @return array
     */
    public function getEvents(): array;
}
