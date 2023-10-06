<?php

namespace AK\Chocobos\Application\ProcessDataInputDNA;

use AK\Shared\Domain\Bus\Query\Query;

class ProcessDataInputDNAQuery extends Query
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