<?php

namespace AK\Shared\Domain\Adapter;

interface FileReaderInterface
{
    public function read(string $filename): array;
}
