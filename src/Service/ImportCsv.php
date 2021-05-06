<?php
declare(strict_types=1);

namespace App\Service;

/**
 * main container for services
*/
final class ImportCsv
{
    /**
     * @var CheckCsv
    */
    public CheckCsv $checkCsv;

    /**
     * @var ReadCsv
     */
    public ReadCsv $readCsv;

    /**
     * @var Analyze
     */
    public Analyze $analyze;

    /**
     * @var AddDataToDb
     */
    public AddDataToDb $addDataToDb;

    /**
     * @var string path to file.csv
     */
    public string $pathFile;

    /**
     * @var bool test mode
     */
    public bool $argument;

    /**
     * @var AllItemsBeforeRead The object after deserialize
    */
    public AllItemsBeforeRead $getReadData;

    /**
     * @var object The array after filter
    */
    public object $objFilterData;

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
     * @return object
    */
    public function processImport(string $pathFile, bool $argument) :object
    {
        $this->pathFile = $pathFile;
        $this->argument = $argument;
        $validFormat = $this->checkCsv->checkFormat($this->pathFile);

        if ($validFormat == false) {
            $err = new ImportErrorsResult('Notice! File format does not match'.PHP_EOL);
            die($err->getErrors());
        }

        try {
            $this->getReadData = $this->readCsv->deserializeFile($pathFile);
        } catch (\Exception $exception) {
            $err = new ImportErrorsResult($exception->getMessage());
            die($err->getErrors());
        }

        if ($this->getReadData->count == 0) {
            $err =  new ImportErrorsResult('Notice! File not read'.PHP_EOL);
            die($err->getErrors());
        }

        $this->objFilterData = $this->analyze->checkCostAndStock($this->getReadData);
        if ($this->objFilterData instanceof ImportErrorsResult) {
            die($this->objFilterData->getErrors());
        }

        if ($argument == false) {
            $resultAddDb = $this->addDataToDb->add($this->objFilterData);
            if ($resultAddDb instanceof ImportErrorsResult) {
                die($resultAddDb->getErrors());
            }
        }

        return $this->objFilterData;
    }
}
