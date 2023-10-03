<?php

namespace AK\ChocoBilly\Application\GetBirdCalculator;

use AK\Shared\Domain\Bus\Query\Query;

class GetBirdCalculatorQuery extends Query
{
    public function __construct(private readonly array $weights, private int $request_weight)
    {
        parent::__construct();
    }

    public function getWeights(): array
    {
        return $this->weights;
    }

    public function getRequestWeight(): int
    {
        return $this->request_weight;
    }
}
