<?php

namespace AK\Shared\Infrastructure\Bus;

use AK\App;
use AK\Shared\Domain\Bus\Command\Command;
use AK\Shared\Domain\Bus\Command\CommandBus;
use AK\Shared\Domain\Bus\Handler;
use AK\Shared\Infrastructure\Config\ServiceInterface;

class SimpleCommandBus implements CommandBus, ServiceInterface
{
    private const HANDLER_PREFIX = 'Handler';

    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function dispatch(Command $command)//: void
    {
        return $this->resolveHandler($command)->__invoke($command);
    }

    private function resolveHandler(Command $command)
    {
        return $this->handler->handle($this->getHandlerClass($command));
    }

    private function getHandlerClass(Command $command): string
    {
        return get_class($command) . self::HANDLER_PREFIX;
    }

    public function load(App $app): void
    {
    }
}
