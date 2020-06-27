<?php


namespace Loxodonta\CommandBus\Tests\Fake;


use Loxodonta\CommandBus\Signature\CommandInterface;

class SimpleCommand implements CommandInterface
{
    public string $var = 'test';
}
