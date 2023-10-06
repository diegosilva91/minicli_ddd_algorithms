<?php

namespace AK\Chocobos\Domain\Entity;

class DNAFile
{
    protected string $name;
    protected int $numb_addition;

    protected array $files;

    public function setName($name): void
    {
        $this->name= $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumbAddition(): int
    {
        return $this->numb_addition;
    }

    public function setNumbAddition(int $numb_addition): void
    {
        $this->numb_addition = $numb_addition;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function setFiles(array $files): void
    {
        $this->files = $files;
    }
}