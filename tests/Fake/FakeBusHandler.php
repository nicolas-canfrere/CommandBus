<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusHandlerInterface;

class FakeBusHandler implements CommandBusHandlerInterface
{
    public function __invoke()
    {

    }

    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return 'Command\Class\Name';
    }
}
