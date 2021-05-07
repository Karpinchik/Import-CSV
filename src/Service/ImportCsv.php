<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\ImportErrorsResult;
use App\ImportData\ImportResult;

/**
 * main container for services
*/
final class ImportCsv
{
    /**
     * @var CheckCsv
    */
    private CheckCsv $checkCsv;

    /**
     * @var ReadCsv
     */
    private ReadCsv $readCsv;

    /**
     * @var Analyze
     */
    private Analyze $analyze;

    /**
     * @var AddDataToDb
     */
    private AddDataToDb $addDataToDb;

    /**
     * @var ImportResult The array after filter
    */
    public ImportResult $objFilterData;

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
     * @param string $pathFile
     * @param bool $argument
     * @return ImportResult
    */
    public function processImport(string $pathFile, bool $argument) :ImportResult
    {
        $validFormat = $this->checkCsv->checkFormat($pathFile);

        if ($validFormat == false) {
            $err = new ImportErrorsResult('Notice! File format does not match'.PHP_EOL);
            die($err->getErrors());
        }

        try {
            $getReadData = $this->readCsv->deserializeFile($pathFile);
        } catch (\Exception $exception) {
            die($exception->getMessage().PHP_EOL);
        }

        if ($getReadData->count == 0) {
            $err =  new ImportErrorsResult('Notice! File not read'.PHP_EOL);
            die($err->getErrors());
        }

        try {
            $this->objFilterData = $this->analyze->checkCostAndStock($getReadData);
        } catch (\Exception $exception) {
            die($exception->getMessage().PHP_EOL);
        }

        if ($argument == false) {
            $this->addDataToDb->add($this->objFilterData);
        }

        return $this->objFilterData;
    }
}
