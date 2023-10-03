<?php

namespace AK\ChocoBilly\Application\ProcessOrder;

use AK\Shared\Domain\Bus\Command\Command;

class ProcessOrderCommand extends Command
{
    public function __construct(
        protected array $content
    ) {
        parent::__construct();
    }

    public function getContent(): array
    {
        return $this->content;
    }

}
