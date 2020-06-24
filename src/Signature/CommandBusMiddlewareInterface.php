<?php


namespace Loxodonta\CommandBus\Signature;

/**
 * Interface CommandBusMiddlewareInterface
 */
interface CommandBusMiddlewareInterface
{
    /**
     * @param $command
     *
     * @param callable $next
     *
     * @return mixed
     */
    public function dispatch($command, callable $next);
}
