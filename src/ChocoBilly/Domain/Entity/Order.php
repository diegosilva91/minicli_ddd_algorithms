<?php

namespace AK\ChocoBilly\Domain\Entity;

class Order
{
    protected array $orderLines;

    public function __construct()
    {
        $this->orderLines = [];
    }

    public function addOrderLine(OrderLine $orderLine): void
    {
        $this->orderLines[] = $orderLine;
    }

    public function getOrderLines(): array
    {
        return $this->orderLines;
    }

    public function removeOrderLine(OrderLine $orderLine): void
    {
        $key = array_search($orderLine, $this->orderLines);
        if ($key !== false) {
            unset($this->orderLines[$key]);
        }
    }
}