<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\ImportErrorsResult;
use App\ImportData\ImportResult;

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
     * @var ImportResult The array after filter
    */
    public ImportResult $objFilterData;

    /**
     * @var ValidatorProduct
     */
    public ValidatorProduct $validatorProduct;

    /**
     * @param CheckCsv $checkCsv
     * @param ReadCsv $readCsv
     * @param Analyze $analyze
     * @param AddDataToDb $addDataToDb
     * @param ValidatorProduct $validatorProduct
    */
    public function __construct(CheckCsv $checkCsv, ReadCsv $readCsv, Analyze $analyze, AddDataToDb $addDataToDb,
                                ValidatorProduct $validatorProduct)
    {
        $this->checkCsv = $checkCsv;
        $this->readCsv = $readCsv;
        $this->analyze = $analyze;
        $this->addDataToDb = $addDataToDb;
        $this->validatorProduct = $validatorProduct;
    }

    /**
     * Main process. Use services - CheckCsv, ReadCsv, Analyze, AddDataToDb
     *
     * @param string $pathFile
     * @param bool $argument
     * @return ImportResult
     * @throws \Exception
    */
    public function processImport(string $pathFile, bool $argument) :ImportResult
    {
        $err = new ImportErrorsResult();
        $validFormat = $this->checkCsv->checkFormat($pathFile);

        if ($validFormat == false) {
            $err->addError('Notice! File format does not use'.PHP_EOL);
        }

        $getReadData = $this->readCsv->deserializeFile($pathFile);

        if ($getReadData->getCount() == 0) {
            $err->addError('Notice! File format does not read'.PHP_EOL);
        }

        try {
            $this->objFilterData = $this->analyze->checkCostAndStock($getReadData, $this->validatorProduct);
        } catch (\Exception $exception) {
            $err->addError($exception->getMessage().PHP_EOL);
        }

        if ($argument == false) {
            $this->addDataToDb->add($this->objFilterData);
        }

        return $this->objFilterData;
    }
}
