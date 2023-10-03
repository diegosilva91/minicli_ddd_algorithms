<?php

namespace AK\Chocobos\Infrastructure\Service;

class Chocobos
{
    public function processModifications($modifications)
    {
        $result = [];
        foreach ($modifications as $modification) {
            $fileName = $modification[0];
            $additions = $modification[1];
            $fileData = '';
            $hash = '';
            
            for ($i = 1; $i <= $additions; $i++) {
                $position = $modification[$i * 2];
                $byte = $modification[$i * 2 + 1];
                
                // Perform the DNA sequence editing and update the fileData
                $fileData = $this->insertByte($fileData, $position, $byte);
                
                // Calculate the CRC32 hash
                $hash = hash('crc32b', $fileData);
                
                // Output the result
                $result[] = "$fileName $i: $hash";
            }
        }
        
        return $result;
    }
    
    private function insertByte($str, $position, $byte)
    {
        // Insert the byte at the specified position
        $before = substr($str, 0, $position);
        $after = substr($str, $position);
        return $before . chr($byte) . $after;
    }
}