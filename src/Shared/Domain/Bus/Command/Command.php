<?php

namespace AK\Shared\Domain\Bus\Command;

use AK\Shared\Domain\Bus\Request;

class Command extends Request
{
    public function requestType(): string
    {
        return 'command';
    }
}
