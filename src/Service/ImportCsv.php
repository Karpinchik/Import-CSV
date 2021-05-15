<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\ParseData;
use App\ImportData\ErrorResult;

/**
 * main container for services
 *
 * Class ImportCsv
 * @package App\Service
 */
final class ImportCsv
{
    /**
     * @var CheckCsv To check format the input file. The should be - .csv
    */
    private CheckCsv $checkCsv;

    /**
     * @var ReadCsv Deserialize csv in to object
     */
    private ReadCsv $readCsv;

    /**
     * @var Analyze Analyze, validate, filter object AllItemsAfterRead and return ImportResult
     */
    private Analyze $analyze;

    /**
     * @var AddDataToDb Add data in to DB
     */
    private AddDataToDb $addDataToDb;

    /**
     * @param CheckCsv $checkCsv
     * @param ReadCsv $readCsv
     * @param Analyze $analyze
     * @param AddDataToDb $addDataToDb
    */
    public function __construct(CheckCsv $checkCsv, ReadCsv $readCsv, Analyze $analyze, AddDataToDb $addDataToDb)
    {
        $this->checkCsv = $checkCsv;
        $this->readCsv = $readCsv;
        $this->analyze = $analyze;
        $this->addDataToDb = $addDataToDb;
    }

    /**
     * Main process. Use services - CheckCsv, ReadCsv, Analyze, AddDataToDb
     *
     * @param string $pathFile
     * @param bool $isArgumentEnterMode
     * @return ParseData
    */
    public function processImport(string $pathFile, bool $isArgumentEnterMode) :ParseData
    {
        $isValidFormat = $this->checkCsv->checkFormat($pathFile);
        $parseData = new ParseData();

        if ($isValidFormat == false) {
            $parseData->setErrorResult(new ErrorResult('Notice! The format of this file is not used. You specified the path to a file with an unknown format.'.PHP_EOL));
            return $parseData;
        }

        try {
            $getReadData = $this->readCsv->deserializeFile($pathFile);
        } catch (\Exception $exception) {
            $parseData->setErrorResult(new ErrorResult('Error! Does not deserialize the file'.PHP_EOL));
            return $parseData;
        }

        if ($getReadData->getCount() == 0) {
            $parseData->setErrorResult(new ErrorResult('Notice! There are no entries in the file.'.PHP_EOL));
            return $parseData;
        }

        try {
            $parseData->setImportResult($this->analyze->checkCostAndStock($getReadData));
        } catch (\Exception $exception) {
            $parseData->setErrorResult(new ErrorResult('Error! Failed to parse the data.'.PHP_EOL));
            return $parseData;
        }
        if ($isArgumentEnterMode == false) {
            try {
                $this->addDataToDb->add($parseData->getImportResult());
            } catch (\Exception $exception) {
                $parseData->setErrorResult(new ErrorResult('Error! Error while writing data to the database .'.PHP_EOL));
                return $parseData;
            }
        }

        return $parseData;
    }
}
