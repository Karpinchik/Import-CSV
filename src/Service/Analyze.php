<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\AllItemsAfterRead;
use App\ImportData\ImportResult;

/**
 * Analyze, validate, filter object AllItemsAfterRead and return ImportResult
 *
 * Class Analyze
 * @package App\Service
 */
class Analyze
{
    /**
     * Analyze, validate, filter object AllItemsAfterRead and return ImportResult
     *
     * @param AllItemsAfterRead $getReadData
     * @param ValidatorProduct $validatorProduct
     * @return ImportResult
     */
    public function checkCostAndStock(AllItemsAfterRead $getReadData, ValidatorProduct $validatorProduct) :ImportResult
    {
        $relevantItems = [];
        $incorrectItems = [];
        $validator = $validatorProduct->getValidatorProduct();

        foreach ($getReadData->getAllProducts() as $value) {
            $error = $validator->validate($value);
            if (count($error) >= 1) {
                $incorrectItems[] = $value;
            } else if (count($error) == 0) {
                $relevantItems[] = $value;
            }
        }

        $countRelevant = count($relevantItems);
        $countIncorrect = $getReadData->getCount() - count($relevantItems);

        $importResult = new ImportResult(
            $relevantItems,
            $incorrectItems,
            $getReadData->getCount(),
            $getReadData->getHeader(),
            $countRelevant,
            $countIncorrect
        );

        return $importResult;
    }
}
