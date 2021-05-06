<?php
declare(strict_types=1);

namespace App\Service;
use Symfony\Component\Validator\Validation;

class Analyze
{
    /**
     * @var ImportResult object with result data
     */
    public ImportResult $importResult;

    /**
     * @var AllItemsBeforeRead
     */
    public AllItemsBeforeRead $getReadData;

    /**
     * @param AllItemsBeforeRead $getReadData
     * @return ImportResult
     */
    public function checkCostAndStock(AllItemsBeforeRead $getReadData) :object
    {
        $this->importResult = new ImportResult();
        $this->getReadData = $getReadData;
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        try {
            foreach ($this->getReadData->allProducts as $value) {
                $error = $validator->validate($value);
                if (count($error) >= 1) {
                    $this->importResult->incorrectItems[$value->productCode] = $value;
                } else if (count($error) == 0) {
                    $this->importResult->relevantItems[$value->productCode] = $value;
                }
            }

            $this->importResult->countAllItems = $this->getReadData->count;
            $this->importResult->countRelevantItems = count($this->importResult->relevantItems);
            $this->importResult->countIncorrectItems = $this->importResult->countAllItems - $this->importResult->countRelevantItems;
            $this->importResult->headers = $this->getReadData->header;

            return $this->importResult;
        } catch (\Exception $exception){

            return new ImportErrorsResult('Notice! not create object for writing in to Db or not analyzed input data'.PHP_EOL);
        }
    }
}
