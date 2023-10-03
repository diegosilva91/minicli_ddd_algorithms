<?php
namespace AK\Shared\Application\GetContentFile;

use AK\Shared\Domain\Adapter\FileReaderInterface;
use AK\Shared\Domain\Bus\Query\Query;
use AK\Shared\Domain\Bus\Query\QueryHandler;

class GetContentFileQueryHandler implements QueryHandler
{
    public function __construct(private readonly FileReaderInterface $fileReader)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(GetContentFileQuery $getContentFileQuery): array
    {
        $fileName = $getContentFileQuery->getFileName();
        $input = __DIR__ . "/../../../../storage/";

        $content = $this->fileReader->read($input . $fileName);
        $this->validateContent($content);
        return $content;
    }

    public function validateContent($dataFile): void
    {
        if (count($dataFile) === 0) {
            throw new \Exception("The structure file does not match with the settings pattern");
        }
        if (is_numeric($dataFile[0]) === false) {
            throw new \Exception("The file does not have a number of cases in number at first line");
        }
    }
}