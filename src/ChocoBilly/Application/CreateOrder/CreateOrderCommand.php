<?php

namespace AK\ChocoBilly\Application\CreateOrder;

use AK\ChocoBilly\Domain\Entity\OrderLine;
use AK\Shared\Domain\Bus\Command\Command;

class CreateOrderCommand extends Command
{
    public function __construct(
        protected OrderLine $orderLine
    ) {
        parent::__construct();
    }
}