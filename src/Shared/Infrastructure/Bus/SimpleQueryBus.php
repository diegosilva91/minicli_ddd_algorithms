<?php

namespace AK\Shared\Infrastructure\Bus;

use AK\App;
use AK\Shared\Domain\Bus\Handler;
use AK\Shared\Domain\Bus\Query\Query;
use AK\Shared\Domain\Bus\Query\QueryBus;
use AK\Shared\Infrastructure\Config\ServiceInterface;

class SimpleQueryBus implements QueryBus, ServiceInterface
{
    private const HANDLER_PREFIX = 'Handler';

    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function ask(Query $query)
    {
        return $this->resolveHandler($query)->__invoke($query);
    }

    private function resolveHandler(Query $query)
    {
        return $this->handler->handle($this->getHandlerClass($query));
    }

    private function getHandlerClass(Query $query): string
    {
        return get_class($query) . self::HANDLER_PREFIX;
    }

    public function load(App $app): void
    {
    }
}
