<?php

namespace AK\Chocobos\Application\ProcessDNA;

use AK\Chocobos\Domain\Entity\DNA;
use AK\Chocobos\Domain\Entity\DNAFile;
use AK\Chocobos\Domain\ValueObject\DNAFileVO;

class ProcessDNACommandHandler
{
    protected DNA $DNA;

    public function __construct()
    {
        $this->DNA = new DNA();
    }
    public function __invoke(ProcessDNACommand $processDNACommand)
    {
        $dataFiles = $processDNACommand->getDataFilesVO();
        /** @var DNAFileVO $dataFile */
        foreach ($dataFiles as $dataFile) {
            $DNAFile = new DNAFile();
            $DNAFile->setName($dataFile->getNameFile());
            $DNAFile->setNumbAddition($dataFile->getNumAddition());
            $DNAFile->setFiles($dataFile->getFiles());
            $this->DNA->addDNAFile($DNAFile);
        }

        $this->outPutSteam();

    }
    private function outPutSteam()
    {
        $output = __DIR__ . "/../../../../storage/";
        $outputFile = fopen($output . "Chocobos/output.txt", "w");
        /** @var DNAFile $DNAFile */
        foreach ($this->DNA->getDNAFiles() as $DNAFile) {
            foreach ($DNAFile->getFiles() as $i => $crc) {
                fwrite(
                    $outputFile,
                    $DNAFile->getName() ." ". $i. ": " . str_pad(dechex($crc), 8, '0', STR_PAD_LEFT) . "\n"
                );
            }
        }
        fclose($outputFile);
    }
}
