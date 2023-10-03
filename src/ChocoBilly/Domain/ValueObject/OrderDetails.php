<?php

namespace AK\ChocoBilly\Domain\ValueObject;

class OrderDetails
{
    public function __construct(
        protected float $request_weight,
        protected array $weights
    ) {
    }

    public function getRequestWeight(): float
    {
        return $this->request_weight;
    }

    public function getWeights(): array
    {
        return $this->weights;
    }
}
