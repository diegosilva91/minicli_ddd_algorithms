<?php

namespace AK\ChocoBilly\Application\CreateOrder;

use AK\ChocoBilly\Domain\Entity\Order;
use AK\Shared\Domain\Bus\Command\Command;

class CreateOrderCommand extends Command
{
    public function __construct(
        protected Order $order
    ) {
        parent::__construct();
    }

    public function getOrder()
    {
        return $this->order;
    }
}