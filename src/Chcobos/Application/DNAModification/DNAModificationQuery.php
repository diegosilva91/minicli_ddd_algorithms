<?php 

namespace AK\Chocobos\Application\DNAModification;

use AK\Shared\Domain\Bus\Query\Query;

class DNAModificationQuery extends Query
{
    public function __construct(
        protected array $content
    ){
        parent::__construct();
    }
    public function getContent():array 
    {
        return $this->content;
    }
}