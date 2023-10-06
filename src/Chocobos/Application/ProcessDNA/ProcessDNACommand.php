<?php

namespace AK\Chocobos\Application\ProcessDNA;

use AK\Shared\Domain\Bus\Command\Command;
use AK\Shared\Domain\ValueObject\Uuid;

class ProcessDNACommand extends Command
{
    public function __construct(protected array $dataFilesVO)
    {
        parent::__construct();
    }

    public function getDataFilesVO(): array
    {
        return $this->dataFilesVO;
    }
}