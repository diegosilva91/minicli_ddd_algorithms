<?php

namespace AK\ChocoBilly\Application\CreateOrder;

class CreateOrderCommandHandler
{
    public function __invoke(CreateOrderCommand $createOrderCommand)
    {
        $outputFile = fopen("output.txt", "w");
        /** Order $order */
        $order = $createOrderCommand->getOrder();
        foreach ($order->getOrderLines() as  $orderLine){
            var_dump($orderLine);
            $birdCount = $orderLine->getCount();
            
            fwrite($outputFile, $birdCount . ":" . implode(",", array_map(function($weight, $count) {
                return $count . ":" . $weight;
            }, array_keys($orderLine->getWeightsAvailable()), $orderLine->getWeightsAvailable())) . "\n");
        }
        fclose($outputFile);
    }
}