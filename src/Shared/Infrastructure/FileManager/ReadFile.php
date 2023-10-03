<?php

namespace AK\Shared\Infrastructure\FileManager;

use AK\Shared\Domain\Adapter\FileReaderInterface;

class ReadFile implements FileReaderInterface
{
    public function read(string $filename): array
    {
        try {
            $file = fopen($filename, "r");
            if ($file === false) {
                throw new \Exception("File cannot be open");
            }

            $lines = [];
            while (($linea = fgets($file)) !== false) {
                $lines[] = trim($linea);
            }

            fclose($file);
            return $lines;
        } catch (\Exception $e) {
            throw new \Exception("Error to read file: " . $e->getMessage());
        }
    }
}
