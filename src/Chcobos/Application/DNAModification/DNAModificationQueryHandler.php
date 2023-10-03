<?php 

namespace AK\Chocobos\Application\DNAModification;

class DNAModificationQueryHandler
{
    public function __invoke(DNAModificationQuery $DNAModificationQuery)
    {
        return $cloning->processModifications($modifications);
    }
}