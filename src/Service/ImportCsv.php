<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\ParseData;

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
     * @var ParseData Result object
     */
    private ParseData $parseData;

    /**
     * @param CheckCsv $checkCsv
     * @param ReadCsv $readCsv
     * @param Analyze $analyze
     * @param AddDataToDb $addDataToDb
     * @param ParseData $parseData
    */
    public function __construct(CheckCsv $checkCsv, ReadCsv $readCsv, Analyze $analyze, AddDataToDb $addDataToDb,
                                ParseData $parseData)
    {
        $this->checkCsv = $checkCsv;
        $this->readCsv = $readCsv;
        $this->analyze = $analyze;
        $this->addDataToDb = $addDataToDb;
        $this->parseData = $parseData;
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

        if ($isValidFormat == false) {
            $this->parseData->errorResult->setErrors('Notice! The format of this file is not used. You specified the path to a file with an unknown format.'.PHP_EOL);
            return $this->parseData;
        }

        try {
            $getReadData = $this->readCsv->deserializeFile($pathFile);
        } catch (\Exception $exception) {
            $this->parseData->errorResult->setErrors('Error! Does not deserialize the file'.PHP_EOL);
            return $this->parseData;
        }

        if ($getReadData->getCount() == 0) {
            $this->parseData->errorResult->setErrors('Notice! There are no entries in the file.'.PHP_EOL);
            return $this->parseData;
        }

        try {
            $this->parseData->importResult = $this->analyze->checkCostAndStock($getReadData);
        } catch (\Exception $exception) {
            $this->parseData->errorResult->setErrors('Error! Failed to parse the data.'.PHP_EOL);
            return $this->parseData;
        }

        if ($isArgumentEnterMode == false) {
            try {
                $this->addDataToDb->add($this->parseData->importResult);
            } catch (\Exception $exception) {
                $this->parseData->errorResult->setErrors('Error! Error while writing data to the database .'.PHP_EOL);
                return $this->parseData;
            }
        }

        return $this->parseData;
    }
}
