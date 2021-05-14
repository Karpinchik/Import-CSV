<?php
declare(strict_types=1);

namespace App\ImportData;

/**
 * Class ErrorResult
 * @package App\ImportData
 */
class ErrorResult
{
    /**
     * @var string
     */
    private string $error;

    /**
     * @param $errorMessage
     */
    public function setErrors($errorMessage) :void
    {
        $this->error = $errorMessage;
    }

    /**
     * @return string
     */
    public function getErrors(): string
    {
        return $this->error;
    }
}
