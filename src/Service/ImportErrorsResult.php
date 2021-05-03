<?php
declare(strict_types=1);

namespace App\Service;

class ImportErrorsResult
{
    private array $errors = [];

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
        if(count($this->errors) > 0) {
            return true;
        }
    }

    public function addError($message)
    {
        $this->errors[] = $message;
    }
}
