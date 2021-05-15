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
     * @var ImportResult|null
     */
    protected ?ImportResult $importResult;

    /**
     * @var ErrorResult|null
     */
    protected ?ErrorResult $errorResult;

    /**
     * ParseData constructor.
     */
    public function __construct()
    {
        $this->errorResult = null;
        $this->importResult = null;
    }

    /**
     * @return ImportResult|null
     */
    public function getImportResult(): ?ImportResult
    {
        return $this->importResult;
    }

    /**
     * @param ImportResult|null $importResult
     */
    public function setImportResult(?ImportResult $importResult): void
    {
        $this->importResult = $importResult;
    }

    /**
     * @return ErrorResult|null
     */
    public function getErrorResult(): ?ErrorResult
    {
        return $this->errorResult;
    }

    /**
     * @param ErrorResult|null $errorResult
     */
    public function setErrorResult(?ErrorResult $errorResult): void
    {
        $this->errorResult = $errorResult;
    }

    /**
     * @return bool
     */
    public function hasErrors() :bool
    {
        return $this->getErrorResult() === null ? false : true;
    }
}
