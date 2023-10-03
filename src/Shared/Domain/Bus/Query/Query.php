<?php

namespace AK\Shared\Domain\Bus\Query;

use AK\App;
use AK\Shared\Domain\Bus\Request;
use AK\Shared\Domain\ValueObject\Uuid;
use AK\Shared\Infrastructure\Config\ServiceInterface;

class Query extends Request
{
    public function requestType(): string
    {
        return 'Query';
    }
}
