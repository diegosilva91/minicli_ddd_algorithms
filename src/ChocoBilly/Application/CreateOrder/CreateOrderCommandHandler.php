<?php

namespace AK\ChocoBilly\Application\CreateOrder;

class CreateOrderCommandHandler
{
    public function __invoke(CreateOrderCommand $createOrderCommand)
    {
        $output = __DIR__ . "/../../../../storage/";
        $outputFile = fopen($output . "ChocoBilly/output.txt", "w");
        /** Order $order */
        $order = $createOrderCommand->getOrder();
        foreach ($order->getOrderLines() as $orderLine) {
            $birdCount = $orderLine->getCount();

            fwrite($outputFile, $birdCount . ":" . implode(",", array_map(function ($weight) {
                    return $weight;
            }, $orderLine->getWeightsAvailable())) . "\n");
        }
        fclose($outputFile);
    }
}