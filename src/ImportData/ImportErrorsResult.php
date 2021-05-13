<?php
declare(strict_types=1);

namespace App\ImportData;

/**
 * Class ImportErrorsResult
 * @package App\ImportData
 */
class ImportErrorsResult
{
    /**
     * @var array
     */
    private array $errors = [];

    /**
     * @return array
     */
    public function getErrors() :array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors() :bool
    {
        if (count($this->errors) > 0) {
            return true;
        } else return false;
    }

    /**
     * @param $message
     */
    public function addError($message) :void
    {
        $this->errors[] = $message;
    }
}
