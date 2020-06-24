<?php


namespace Loxodonta\CommandBus\Signature;

/**
 * Interface CommandBusHandlerInterface
 */
interface CommandBusHandlerInterface
{
    /**
     * @return string
     */
    public function listenTo(): string;
}
