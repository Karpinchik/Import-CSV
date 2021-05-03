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
     * @var string path to file.csv
     */
    public string $pathFile;

    /**
     * @var bool test mode
     */
    public bool $argument;

    /**
     * @var array The array after deserialize
    */
    public array $arrayData;

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

            return new ImportErrorsResult('file format does not match');
        }

        $arrayData = $this->readCsv->deserializeFile($pathFile);

        if (isset($arrayData['error'])) {

            return new ImportErrorsResult('could not read the file');
        }

        $this->objFilterData = $this->analyze->checkCostAndStock($arrayData);

        if ($this->objFilterData instanceof ImportErrorsResult) {

            return $this->objFilterData;
        } else {
            if ($argument == false) {
                $resultAddDb = $this->addDataToDb->add($this->objFilterData);

                if ($resultAddDb instanceof ImportErrorsResult) {

                    return new ImportErrorsResult($resultAddDb->getErrors());
                }
            }
        }

        return $this->objFilterData;
    }
}
