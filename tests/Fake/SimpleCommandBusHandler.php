<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusHandlerInterface;
use Loxodonta\CommandBus\CommandResponse;
use Loxodonta\CommandBus\Signature\CommandResponseInterface;

class SimpleCommandBusHandler implements CommandBusHandlerInterface
{
    public function __invoke(SimpleCommand $command): CommandResponseInterface
    {
        return new CommandResponse($this->listenTo(), [new \stdClass()]);
    }

    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return SimpleCommand::class;
    }
}
