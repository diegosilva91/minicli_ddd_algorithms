<?php

namespace AK\ChocoBilly\Domain\Entity;

class OrderLine
{
    protected array $weights_available = [];

    public function getWeightsAvailable(): array
    {
        return $this->weights_available;
    }

    public function setWeightsAvailable(array $weights): void
    {
        $this->weights_available = $weights;
    }

    public function getCount(): int
    {
        return count($this->weights_available);
    }

    public function getTotalWeightAvailable(): float|int
    {
        return array_sum($this->weights_available);
    }
}
