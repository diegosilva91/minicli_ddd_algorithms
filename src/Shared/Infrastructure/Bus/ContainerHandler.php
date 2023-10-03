<?php

namespace AK\Shared\Infrastructure\Bus;

use AK\App;
use AK\Shared\Domain\Bus\Handler;
use AK\Shared\Infrastructure\DI\Container;

class ContainerHandler  implements Handler, \AK\Shared\Infrastructure\Config\ServiceInterface
{

    private Container $container;


    public function handle($class)
    {
        return (Container::getInstance())->make($class);
    }

    public function load(App $app): void
    {
    }
}