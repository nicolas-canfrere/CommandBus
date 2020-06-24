<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusMiddlewareInterface;

class AnotherMiddleware implements CommandBusMiddlewareInterface
{

    /**
     * @inheritDoc
     */
    public function dispatch($command, callable $next)
    {
        $command->var = sprintf('%s and modified again', $command->var);
        $result = $next($command);
        $command->var = $command->var . ' and again';
        return $result;
    }
}
