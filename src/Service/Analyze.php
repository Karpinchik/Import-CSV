<?php
declare(strict_types=1);

namespace App\Service;

class Analyze
{
    /**
     * @var ImportResult object with result data
    */
    public ImportResult $importResult;

    /**
     * @param array $arrayData
     * @return object
     */
    public function checkCostAndStock(array $arrayData) :object
    {
        $this->importResult = new ImportResult();
        try {
            foreach ($arrayData['All products'] as $key => $value) {
                if ( is_numeric($value['Stock']) && is_numeric($value['Cost in GBP']) )
                {
                    $resultToImport[$value['Product Code']] = $value;
                }
                else {
                    $this->importResult->incorrectItems[$value['Product Code']] = $value;
                }
            }

            foreach ($resultToImport as $key => $value) {
                if ((intval($value['Cost in GBP']) >= 5) && (intval($value['Stock']) >= 10)
                    && (intval($value['Cost in GBP']) < 1000)) {
                    $this->importResult->relevantItems[$value['Product Code']] = $value;
                }
            }

            $this->importResult->countAllItems = $arrayData['count'];
            $this->importResult->incorrectItems = array_diff_key($resultToImport, $this->importResult->relevantItems);
            $this->importResult->countRelevantItems = count($this->importResult->relevantItems);
            $this->importResult->countIncorrectItems = $this->importResult->countAllItems - $this->importResult->countRelevantItems;
            $this->importResult->headers = $arrayData['header'];

            return $this->importResult;
        } catch (\Exception $exception){

            return new ImportErrorsResult('не удалось сформировать массив для записис в БД');
        }
    }
}
