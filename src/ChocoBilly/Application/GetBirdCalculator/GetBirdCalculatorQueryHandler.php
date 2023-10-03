<?php

namespace AK\ChocoBilly\Application\GetBirdCalculator;

use AK\ChocoBilly\Domain\Repository\BirdsRepository;
use AK\ChocoBilly\Domain\ValueObject\OrderDetails;
use AK\Shared\Domain\Bus\Query\QueryHandler;

class GetBirdCalculatorQueryHandler implements QueryHandler
{
    public function __construct(private BirdsRepository $birdsRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(GetBirdCalculatorQuery $getBirdCalculatorQuery)
    {
        $weights = $getBirdCalculatorQuery->getWeights();

        $request_weight = $getBirdCalculatorQuery->getRequestWeight();


        $orderDetails = new OrderDetails($request_weight, $weights);
        return $this->birdsRepository->computeBirds($orderDetails);
    }
}
