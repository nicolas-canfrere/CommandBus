<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusMiddlewareInterface;

class SimpleMiddleware implements CommandBusMiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function dispatch($command, callable $next)
    {
        $command->var = sprintf('%s modified', $command->var);

        return $next($command);
    }
}
