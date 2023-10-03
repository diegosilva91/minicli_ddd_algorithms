<?php

namespace AK\Shared\Domain\Bus;

use AK\Shared\Domain\ValueObject\Uuid;

abstract class Request
{
    private Uuid $requestId;

    public function __construct(Uuid $requestId = null)
    {
        $this->requestId = $requestId ?: Uuid::random();
    }

    public function requestId(): Uuid
    {
        return $this->requestId;
    }

    abstract public function requestType(): string;
}