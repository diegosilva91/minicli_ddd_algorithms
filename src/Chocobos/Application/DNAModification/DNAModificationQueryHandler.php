<?php

namespace AK\Chocobos\Application\DNAModification;

use AK\Chocobos\Application\ProcessDataInputDNA\ProcessDataInputDNAQuery;
use AK\Chocobos\Domain\Repository\DNACloningRepository;
use AK\Shared\Domain\Bus\Query\QueryBus;

class DNAModificationQueryHandler
{
    public function __construct(
        public QueryBus    $queryBus,
        private readonly DNACloningRepository $DNACloningRepositoryCloning
    ) {
    }

    public function __invoke(DNAModificationQuery $DNAModificationQuery)
    {
        $content = $DNAModificationQuery->getContent();

        $modifications = $this->queryBus->ask(
            new ProcessDataInputDNAQuery($content)
        );

        return $this->DNACloningRepositoryCloning->processModifications($modifications);
    }
}
