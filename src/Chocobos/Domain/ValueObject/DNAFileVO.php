<?php

namespace AK\Chocobos\Domain\ValueObject;

class DNAFileVO
{
    private $nameFile;
    private $numAddition;
    private $files;

    public function __construct($nameFile, $numAddition, $files)
    {
        $this->nameFile = $nameFile;
        $this->numAddition = $numAddition;
        $this->files = $files;
    }

    public function getNameFile()
    {
        return $this->nameFile;
    }

    public function getNumAddition()
    {
        return $this->numAddition;
    }

    public function getFiles()
    {
        return $this->files;
    }
    public static function createFromDataFileProcess($name_file, $numb_addition, $file): self
    {
        return new self($name_file, $numb_addition, $file);
    }
}