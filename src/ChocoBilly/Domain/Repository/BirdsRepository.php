<?php

namespace AK\ChocoBilly\Domain\Repository;

use AK\ChocoBilly\Domain\ValueObject\OrderDetails;

interface BirdsRepository
{
    public function computeBirds(OrderDetails $orderDetails);
}
