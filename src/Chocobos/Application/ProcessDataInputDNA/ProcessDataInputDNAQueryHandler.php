<?php

namespace AK\Chocobos\Application\ProcessDataInputDNA;

class ProcessDataInputDNAQueryHandler
{
    public function __invoke(ProcessDataInputDNAQuery $processDataInputDNAQuery)
    {
        $content = $processDataInputDNAQuery->getContent();
        $result = [];

        do {
            $line = [];
            $mod = explode(" ", $content[0]);
            $name = $mod[0];
            $line[] = $name;
            $num_additions = $mod[1];
            $line[] = $num_additions;

            $content = array_slice($content, 1);
            $additions = array_splice($content, 0, intval($num_additions));

            foreach ($additions as $addition) {
                $additionData = explode(" ", $addition);
                $line[] = $additionData;
            }
            $result[] = $line;
        } while (count($content) > 0);
        return $result;
    }
}
