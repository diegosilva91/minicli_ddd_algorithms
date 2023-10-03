<?php

namespace AK\Shared\Infrastructure\Config;

use AK\App;

interface ServiceInterface
{
    /**
     * load application
     *
     * @param App $app
     * @return void
     */
    public function load(App $app): void;
}