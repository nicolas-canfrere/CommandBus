<?php


namespace Loxodonta\CommandBus\Signature;

use Loxodonta\CommandBus\CommandBus;
use Loxodonta\CommandBus\Exception\CommandHandlerNotCallableException;
use Loxodonta\CommandBus\Exception\CommandHasNoHandlerException;

/**
 * Interface CommandBusInterface
 */
interface CommandBusInterface
{
    /**
     * @param CommandBusHandlerInterface $handler
     *
     * @return CommandBusInterface
     * @throws CommandHandlerNotCallableException
     */
    public function registerHandler(CommandBusHandlerInterface $handler): CommandBusInterface;

    /**
     * @param CommandBusMiddlewareInterface $middleware
     *
     * @return CommandBus
     */
    public function registerMiddleware(CommandBusMiddlewareInterface $middleware): CommandBus;

    /**
     * @param $command
     *
     * @return mixed
     * @throws CommandHasNoHandlerException
     */
    public function dispatch(CommandInterface $command): CommandResponseInterface;

    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasHandlerFor(string $className): bool;

    /**
     * @param CommandBusMiddlewareInterface $middleware
     *
     * @return bool
     */
    public function hasMiddleware(CommandBusMiddlewareInterface $middleware): bool;
}
