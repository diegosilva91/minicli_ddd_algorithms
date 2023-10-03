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
        
        $this->detectMemory(count($weights), $request_weight);
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

    public function detectMemory($elements, $size_number)
    {
        $memorySize = $elements * $size_number + $size_number;
        
        $actualMemory = memory_get_usage();
        
        echo "Currently allocated memory: " . round($actualMemory, 2) . " KB (or " . round($actualMemory / 1024, 2) . " MB)\n";
        echo "Required memory size: " . round($memorySize, 2) . " KB\n";
        
        if ($memorySize > $actualMemory) {
            $this->allowMemory();
            echo "Memory increased to " . round(memory_get_usage() / 1024, 2) . " MB\n";
        }
    }

    private function allowMemory()
    {
        ini_set('memory_limit', "-1");
        ini_set('max_execution_time', 480);
        set_time_limit(0);
        error_reporting(E_ALL & ~E_NOTICE);
    }
}