<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusMiddlewareInterface;

class AnotherMiddleware implements CommandBusMiddlewareInterface
{
    /**
     * @var Spy
     */
    private Spy $spy;

    public function __construct(Spy $spy)
    {
        $this->spy = $spy;
    }
    /**
     * @inheritDoc
     */
    public function dispatch($command, callable $next)
    {
        $this->spy->report();
        $result = $next($command);
        $this->spy->report();
        return $result;
    }
}
