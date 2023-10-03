<?php

namespace AK\ChocoBilly\Infrastructure\Service;

use AK\ChocoBilly\Domain\Repository\BirdsRepository;
use AK\ChocoBilly\Domain\ValueObject\OrderDetails;

class BirdsService implements BirdsRepository
{
    public function __construct()
    {
    }

    public function computeBirds(OrderDetails $orderDetails)
    {
        $request_weight = $orderDetails->getRequestWeight();
        $weights = $orderDetails->getWeights();
        $itemsUsed = $this->knapsack($request_weight, $weights);
        return $itemsUsed;
    }

    private function knapsack($capacity, $weight): array
    {
        $n = count($weight);
        $dp = array_fill(0, $n + 1, array_fill(0, $capacity + 1, 0));

        for ($i = 1; $i <= $n; $i++) {
            for ($j = 1; $j <= $capacity; $j++) {
                if ($weight[$i - 1] <= $j) {
                    $dp[$i][$j] = max($dp[$i - 1][$j], $dp[$i - 1][$j - $weight[$i - 1]] + $weight[$i - 1]);
                } else {
                    $dp[$i][$j] = $dp[$i - 1][$j];
                }
            }
        }

        $weightUsed = array();
        $i = $n;
        $j = $capacity;
        while ($i > 0 && $j > 0) {
            if ($dp[$i][$j] != $dp[$i - 1][$j]) {
                $weightUsed[] = $weight[$i - 1];
                $j -= $weight[$i - 1];
            }
            $i--;
        }

        return $weightUsed;
    }
}