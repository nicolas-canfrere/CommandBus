<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusHandlerInterface;

class NotCallableBusHandler implements CommandBusHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return 'commandName';
    }
}
