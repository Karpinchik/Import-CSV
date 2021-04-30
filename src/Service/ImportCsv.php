<?php
declare(strict_types=1);

namespace App\Service;

/**
 * main container for services
*/
class ImportCsv
{
    /**
     * @var object
    */
    public object $checkCsv;

    /**
     * @var object
     */
    public object $readCsv;

    /**
     * @var object
     */
    public object $analyze;

    /**
     * @var object
     */
    public object $addDataToDb;

    /**
     * @var string
     */
    public string $pathFile;

    /**
     * @var string
     */
    public string $argument;

    /**
     * @var array The array after deserialize
    */
    public array $arrayData;

    /**
     * @var array The array after filter
    */
    public array $arrayFilterData;

    /**
     * @var string status execution add()
    */
    public string $statusAdd;

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
     * @param string $argument
     * @return array
    */
    public function processImport(string $pathFile, string $argument) :array
    {
        $this->pathFile = $pathFile;
        $this->argument = $argument;
        $validFormat = $this->checkCsv->checkFormat($this->pathFile);

        // можно создать свойство error и использовать ниже
        if ($validFormat == 0) return ['no csv'];
        $arrayData = $this->readCsv->deserializeFile($pathFile);
        if (isset($arrayData['error'])) return ['error deserialize'];
        $arrayFilterData = $this->analyze->checkCostAndStock($arrayData);
        if (!empty($arrayFilterData['error'])) return ['error filter data'];

        if ($argument !== 'test') {
            $resultAddDb = $this->addDataToDb->add($arrayFilterData);

            if ($resultAddDb == true) {
                $this->statusAdd = 'data added';
                $arrayFilterData['status add'] = $this->statusAdd;
            } else {
                $arrayFilterData['status add'] = 'data not added';
            }
        } else {
            $arrayFilterData['status add'] = 'test mode';
        }

        return $arrayFilterData;
    }
}
