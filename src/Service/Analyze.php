<?php
declare(strict_types=1);

namespace App\Service;

use App\ImportData\AllItemsAfterRead;
use App\ImportData\ImportResult;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Analyze, validate, filter object AllItemsAfterRead and return ImportResult
 *
 * Class Analyze
 * @package App\Service
 */
class Analyze
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * Analyze constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Analyze, validate, filter object AllItemsAfterRead and return ImportResult
     *
     * @param AllItemsAfterRead $getReadData
     * @return ImportResult
     */
    public function checkCostAndStock(AllItemsAfterRead $getReadData) :ImportResult
    {
        $relevantItems = [];
        $incorrectItems = [];

        foreach ($getReadData->getAllProducts() as $value) {
            $error = $this->validator->validate($value);

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
