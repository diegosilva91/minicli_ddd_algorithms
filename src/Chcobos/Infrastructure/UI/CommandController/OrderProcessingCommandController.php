<?php

namespace AK\ChocoBilly\Infrastructure\UI\CommandController;

use AK\ChocoBilly\Application\ProcessOrder\ProcessOrderCommand;
use AK\Shared\Application\GetContentFile\GetContentFileQuery;
use AK\Shared\Domain\Bus\Command\CommandBus;
use AK\Shared\Domain\Bus\Query\QueryBus;
use AK\Shared\Infrastructure\UI\CommandController\BaseCommandController;

class OrderProcessingCommandController extends BaseCommandController
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

        $this->commandBus->dispatch(
            new DNAModificationQuery($content)
        );

        $queryFileOutput = new GetContentFileQuery("Chocobos/output.txt");
        $this->getPrinter()->display(sprintf("Order generated in folder storage!"));

        foreach ($queryFileOutput as $item) {
            $this->getPrinter()->display($item);
        }
    }
}
