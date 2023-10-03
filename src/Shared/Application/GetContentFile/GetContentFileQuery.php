<?php
namespace AK\Shared\Application\GetContentFile;

use AK\Shared\Domain\Bus\Query\Query;

class GetContentFileQuery extends Query
{
    public function __construct(private string $fileName)
    {
        parent::__construct();
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}