<?php

namespace Loxodonta\CommandBus;

use Loxodonta\CommandBus\Exception\CommandHandlerNotCallableException;
use Loxodonta\CommandBus\Exception\CommandHasNoHandlerException;
use Loxodonta\CommandBus\Signature\CommandBusInterface;
use Loxodonta\CommandBus\Signature\CommandBusHandlerInterface;
use Loxodonta\CommandBus\Signature\CommandBusMiddlewareInterface;
use Loxodonta\CommandBus\Signature\CommandInterface;
use Loxodonta\CommandBus\Signature\CommandResponseInterface;

/**
 * Class CommandBus
 */
class CommandBus implements CommandBusInterface
{
    protected array $handlers = [];

    protected array $middlewares = [];

    /**
     * @inheritDoc
     */
    public function registerHandler(CommandBusHandlerInterface $handler): CommandBusInterface
    {
        if (!is_callable($handler)) {
            throw new CommandHandlerNotCallableException(
                sprintf('%s is not callable', get_class($handler))
            );
        }
        $this->handlers[$handler->listenTo()] = $handler;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function registerMiddleware(CommandBusMiddlewareInterface $middleware): CommandBus
    {
        $this->middlewares[] = $middleware;

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function dispatch(CommandInterface $command): CommandResponseInterface
    {
        $key = get_class($command);
        if ($this->hasHandlerFor($key)) {

            $current = array_pop($this->middlewares);
            if (is_null($current)) {
                return $this->handlers[$key]($command);
            }

            return $current->dispatch($command, [$this, 'dispatch']);
        }

        throw new CommandHasNoHandlerException(
            sprintf('%s command has no handler', $key)
        );
    }

    /**
     * @inheritDoc
     */
    public function hasHandlerFor(string $className): bool
    {
        return !empty($this->handlers[$className]);
    }

    /**
     * @inheritDoc
     */
    public function hasMiddleware(CommandBusMiddlewareInterface $middleware): bool
    {
        return in_array($middleware, $this->middlewares, true);
    }
}
