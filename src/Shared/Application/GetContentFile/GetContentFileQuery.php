<?php

namespace AK\Shared\Application\GetContentFile;

use AK\Shared\Domain\Bus\Query\Query;

class GetContentFileQuery extends Query
{
    public function __construct(
        private string $fileName,
        private ?bool $need_validation = false
    ) {
        parent::__construct();
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getNeedValidation(): ?bool
    {
        return $this->need_validation;
    }
}