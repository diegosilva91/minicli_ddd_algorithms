<?php

namespace AK\ChocoBilly\Application\ProcessOrder;

use AK\ChocoBilly\Application\CreateOrder\CreateOrderCommand;
use AK\ChocoBilly\Application\GetBirdCalculator\GetBirdCalculatorQuery;
use AK\ChocoBilly\Domain\Entity\Order;
use AK\ChocoBilly\Domain\Entity\OrderLine;
use AK\Shared\Domain\Bus\Command\CommandBus;
use AK\Shared\Domain\Bus\Query\QueryBus;

class ProcessOrderCommandHandler
{
    public function __construct(
        public QueryBus    $queryBus,
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(ProcessOrderCommand $processOrderCommand): void
    {
        $content = $processOrderCommand->getContent();
        $cases = intval($content[0]);

        $order = new Order();
        for ($i = 0; $i < $cases; $i++) {
            $weights = explode(",", $content[2 * $i + 1]);
            $request_weight = intval($content[2 * $i + 2]);


            $result = $this->queryBus->ask(
                new GetBirdCalculatorQuery($weights, $request_weight)
            );

            $orderLine = new OrderLine();
            $orderLine->setWeightsAvailable($result);
            $order->addOrderLine($orderLine);
        }
var_dump($order);
        $this->commandBus->dispatch(
            new CreateOrderCommand($order)
        );
    }
}
