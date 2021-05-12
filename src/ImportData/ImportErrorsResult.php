<?php
declare(strict_types=1);

namespace App\ImportData;

class ImportErrorsResult
{
    /**
     * @var array
     */
    private array $errors = [];

    /**
     * ImportErrorsResult constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->errors[] = $message;
    }

    public function getErrors() :string
    {
        return $this->errors[0];
    }

    public function hasErrors() :bool
    {
        if (count($this->errors) > 0) {
            return true;
        } else return false;
    }

    public function addError($message)
    {
        $this->errors[] = $message;
    }
}
