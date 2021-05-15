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
     * ErrorResult constructor.
     * @param string $error
     */
    public function __construct(string $error)
    {
        $this->error = $error;
    }

    /**
     * @param $errorMessage
     */
    public function setError($errorMessage) :void
    {
        $this->error = $errorMessage;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}
