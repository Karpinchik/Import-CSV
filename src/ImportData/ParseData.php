<?php
declare(strict_types=1);

namespace App\ImportData;

/**
 * Class ParseData
 * @package App\ImportData
 */
class ParseData
{
    /**
     * @var ImportResult
     */
    public ImportResult $importResult;

    /**
     * @var ErrorResult
     */
    public ErrorResult $errorResult;

    /**
     * ParseData constructor.
     * @param ErrorResult $errorResult
     */
    public function __construct(ErrorResult $errorResult)
    {
        $this->errorResult = $errorResult;
    }

    /**
     * @return bool
     */
    public function hasErrors() :bool
    {
        if (count((array)$this->errorResult) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
