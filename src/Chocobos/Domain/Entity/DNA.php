<?php

namespace AK\Chocobos\Domain\Entity;

class DNA
{
    protected array $DNAFiles;

    public function __construct()
    {
        $this->DNAFiles = [];
    }

    public function addDNAFile(DNAFile $DNAFile): void
    {
        $this->DNAFiles[] = $DNAFile;
    }

    public function getDNAFiles(): array
    {
        return $this->DNAFiles;
    }

    public function removeOrderLine(DNAFile $DNAFile): void
    {
        $key = array_search($DNAFile, $this->DNAFiles);
        if ($key !== false) {
            unset($this->DNAFiles[$key]);
        }
    }
}
