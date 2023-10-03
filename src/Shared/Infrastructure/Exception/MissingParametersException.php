<?php

namespace AK\Shared\Infrastructure\Exception;

use Exception;
final class MissingParametersException extends Exception
{
    /**
     * @param array<int,string> $missing
     */
    public function __construct(array $missing)
    {
        parent::__construct(sprintf(
            'Missing required parameter(s): %s',
            implode(', ', $missing)
        ));
    }
}