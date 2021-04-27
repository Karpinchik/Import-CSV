<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\CheckCsv;
use App\Service\ReadCsv;
use App\Service\Analyze;
use App\Service\AddDataToDb;


class ImportCsv
{
    /**
     * @var string the path to csv file
    */
    public $pathFile = 'stock.csv';
    public $checkCsv;
    public $readCsv;
    public $analyze;
    public $addDataToDb;

    /**
     * @param \App\Service\CheckCsv $checkCsv
     * @param \App\Service\ReadCsv $readCsv
     * @param \App\Service\Analyze $analyze
     * @param \App\Service\AddDataToDb $addDataToDb
     */
    public function __constructor(CheckCsv $checkCsv, ReadCsv $readCsv, Analyze $analyze, AddDataToDb $addDataToDb)
    {
        $this->checkCsv = $checkCsv;
        $this->readCsv = $readCsv;
        $this->analyze = $analyze;
        $this->addDataToDb = $addDataToDb;
    }

    /**
     * main function
     *
     * @return
    */
    public function processImport()
    {
        $checkCsv = new CheckCsv();
        $readCsv = new ReadCsv();
        $analyse = new Analyze();
        $addDataToDb = new AddDataToDb();

        $validFormat = $checkCsv->checkFormat($this->pathFile);

        if($validFormat == 0) return 'no csv';

        $arrayData = $readCsv->deserializeFile($this->pathFile);
        $arrayFilterData = $analyse->checkCostAndStock($arrayData);

        $res = $addDataToDb->add();

        return print_r($res);
    }
}
