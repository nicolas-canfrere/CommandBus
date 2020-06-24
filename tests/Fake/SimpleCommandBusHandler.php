<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandBusHandlerInterface;

class SimpleCommandBusHandler implements CommandBusHandlerInterface
{
    public function __invoke(SimpleCommand $command)
    {
        return $this->listenTo();
    }

    /**
     * @inheritDoc
     */
    public function listenTo(): string
    {
        return SimpleCommand::class;
    }
}
