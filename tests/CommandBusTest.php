<?php


namespace Loxodonta\CommandBus\Tests;


use Loxodonta\CommandBus\CommandBus;
use Loxodonta\CommandBus\Exception\CommandHandlerNotCallableException;
use Loxodonta\CommandBus\Exception\CommandHasNoHandlerException;
use Loxodonta\CommandBus\Signature\CommandBusInterface;
use Loxodonta\CommandBus\Signature\CommandBusMiddlewareInterface;
use Loxodonta\CommandBus\Tests\Fake\AnotherMiddleware;
use Loxodonta\CommandBus\Tests\Fake\FakeBusHandler;
use Loxodonta\CommandBus\Tests\Fake\NotCallableBusHandler;
use Loxodonta\CommandBus\Tests\Fake\SimpleCommand;
use Loxodonta\CommandBus\Tests\Fake\SimpleCommandBusHandler;
use Loxodonta\CommandBus\Tests\Fake\SimpleMiddleware;
use PHPUnit\Framework\TestCase;

class CommandBusTest extends TestCase
{
    /**
     * @test
     */
    public function itImplementsCommandBusInterface()
    {
        $cb = new CommandBus();
        $this->assertInstanceOf(CommandBusInterface::class, $cb);
    }

    /**
     * @test
     */
    public function itCanRegisterHandlers()
    {
        $cb = new CommandBus();
        $handler = new FakeBusHandler();

        $this->assertFalse($cb->hasHandlerFor($handler->listenTo()));

        $cb->registerHandler($handler);

        $this->assertTrue($cb->hasHandlerFor($handler->listenTo()));
    }

    /**
     * @test
     */
    public function itMustThrowExceptionIfHandlerIsNotCallable()
    {
        $cb = new CommandBus();
        $handler = new NotCallableBusHandler();

        $this->expectException(CommandHandlerNotCallableException::class);
        $cb->registerHandler($handler);
    }

    /**
     * @test
     */
    public function itCanDispatchCommand()
    {
        $cb = new CommandBus();
        $handler = new SimpleCommandBusHandler();
        $cb->registerHandler($handler);

        $this->assertTrue($cb->hasHandlerFor(SimpleCommand::class));

        $result = $cb->dispatch(new SimpleCommand());

        $this->assertEquals(SimpleCommand::class, $result);
    }

    /**
     * @test
     */
    public function itMustThrowExceptionIfThereIsNoHandlerForCommand()
    {
        $cb = new CommandBus();

        $this->expectException(CommandHasNoHandlerException::class);
        $cb->dispatch(new SimpleCommand());
    }

    /**
     * @test
     */
    public function itCanRegisterMiddleware()
    {
        $mw = $this->createMock(CommandBusMiddlewareInterface::class);

        $cb = new CommandBus();
        $cb->registerMiddleware($mw);

        $this->assertTrue($cb->hasMiddleware($mw));
    }

    /**
     * @test
     */
    public function withOneMiddleware()
    {
        $cb = new CommandBus();
        $mw = new SimpleMiddleware();
        $handler = new SimpleCommandBusHandler();

        $cb->registerMiddleware($mw);
        $cb->registerHandler($handler);

        $command = new SimpleCommand();
        $initial = $command->var;

        $result = $cb->dispatch($command);

        $this->assertEquals(SimpleCommand::class, $result);

        // for test only, middlewares are not suppose to alter the command object !

        $this->assertEquals(sprintf('%s modified', $initial), $command->var);
    }

    /**
     * @test
     */
    public function withMultipleMiddlewares()
    {
        $cb = new CommandBus();
        $amw = new AnotherMiddleware();
        $mw = new SimpleMiddleware();
        $handler = new SimpleCommandBusHandler();

        $cb->registerMiddleware($amw);
        $cb->registerMiddleware($mw);
        $cb->registerHandler($handler);

        $command = new SimpleCommand();
        $initial = $command->var;

        $result = $cb->dispatch($command);

        $this->assertEquals(SimpleCommand::class, $result);

        $expected = sprintf(
            '%s and modified again and again',
            sprintf('%s modified', $initial)
        );

        $this->assertEquals($expected, $command->var);
    }
}
