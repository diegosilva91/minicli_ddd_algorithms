<?php

namespace AK\Shared\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command);//: void;
}