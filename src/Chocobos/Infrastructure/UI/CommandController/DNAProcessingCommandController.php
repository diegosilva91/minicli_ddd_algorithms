<?php

namespace AK\Chocobos\Infrastructure\UI\CommandController;

use AK\Chocobos\Application\DNAModification\DNAModificationQuery;
use AK\Chocobos\Application\ProcessDNA\ProcessDNACommand;
use AK\Shared\Application\GetContentFile\GetContentFileQuery;
use AK\Shared\Domain\Bus\Command\CommandBus;
use AK\Shared\Domain\Bus\Query\QueryBus;
use AK\Shared\Infrastructure\UI\CommandController\BaseCommandController;

class DNAProcessingCommandController extends BaseCommandController
{
    public function __construct(
        public QueryBus    $queryBus,
        private CommandBus $commandBus
    ) {
    }

    public function handle(): void
    {
        $name = $this->hasParam('user') ? $this->getParam('user') : 'ChocoBilly';

        $this->getPrinter()->display(sprintf("Hello, %s!", $name));

        $queryFile = new GetContentFileQuery("Chocobos/input.txt");
        $content = $this->queryBus->ask($queryFile);


        $dataFiles = $this->queryBus->ask(
            new DNAModificationQuery($content)
        );

        $this->commandBus->dispatch(
            new ProcessDNACommand($dataFiles['dataObjects'])
        );

        $contentFileOutput = $this->queryBus->ask(
            new GetContentFileQuery("Chocobos/output.txt")
        );

        $this->getPrinter()->display(sprintf("Order generated in folder storage!"));

        foreach ($contentFileOutput as $item) {
            $this->getPrinter()->display($item);
        }
    }
}
