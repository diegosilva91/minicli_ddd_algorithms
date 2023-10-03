<?php

namespace AK\Shared\Domain\Bus;

interface Handler
{
    public function handle($class);
}