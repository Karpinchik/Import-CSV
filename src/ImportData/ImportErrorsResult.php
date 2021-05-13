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
    public static array $arrayErrors = [];

    /**
     * @param $message
     */
    public static function addError($message) :void
    {
        self::$arrayErrors[] = $message;
    }
}
