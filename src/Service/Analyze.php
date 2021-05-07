<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\AllItemsAfterRead;
use App\ImportData\ImportResult;
use Symfony\Component\Validator\Validation;

class Analyze
{
    /**
     * @param AllItemsAfterRead $getReadData
     * @return ImportResult
     */
    public function checkCostAndStock(AllItemsAfterRead $getReadData) :ImportResult
    {
        $relevantItems = [];
        $incorrectItems = [];

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        foreach ($getReadData->allProducts as $value) {
            $error = $validator->validate($value);
            if (count($error) >= 1) {
                $incorrectItems[] = $value;
            } else if (count($error) == 0) {
                $relevantItems[] = $value;
            }
        }

        $countRelevant = count($relevantItems);
        $countIncorrect = $getReadData->count - count($relevantItems);

        $importResult = new ImportResult(
            $relevantItems,
            $incorrectItems,
            $getReadData->count,
            $getReadData->header,
            $countRelevant,
            $countIncorrect
        );

        return $importResult;
    }
}
