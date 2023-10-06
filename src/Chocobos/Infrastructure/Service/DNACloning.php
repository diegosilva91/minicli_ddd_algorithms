<?php

namespace AK\Chocobos\Infrastructure\Service;

use AK\Chocobos\Domain\Repository\DNACloningRepository;
use AK\Chocobos\Domain\ValueObject\DNAFileVO;

class DNACloning implements DNACloningRepository
{
    public function processModifications($modifications)
    {
        return $this->computeCrc32($modifications);
    }

    private function computeCrc32($modifications)
    {
        $modificationObjects = [];
        $files = [];
        foreach ($modifications as $key => $mod) {
            $name = $mod[0];
            $numb_addition = $mod[1];
            $addition = array_slice($mod, 2);
            $addition[-1] = [null,null];

            $name_file = $name . " " . $numb_addition;
            $content = str_split(null);

            for ($i = -1; $i < $numb_addition; $i++) {
                $pos =  $addition[$i][0] ?? $addition[$i+1][0];
                $byte = $addition[$i][1];

                if ($key !== 0 || $i !== -1) {
                    array_splice($content, $pos, 1, chr($byte));
                }
                $content_str = implode('', $content);


                $crc = crc32($content_str);
                $files[$name_file][] = $crc;
            }
            $modificationInfo = DNAFileVO::createFromDataFileProcess($name, $numb_addition, $files[$name_file]);
            $modificationObjects[] = $modificationInfo;
        }
        return ['dataFiles'=>$files,
            'dataObjects' => $modificationObjects];
    }
}
