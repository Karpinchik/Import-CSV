<?php
declare(strict_types=1);

namespace App\Service;

class ImportResult
{
    /**
     * @var array all relevant items in the array
     */
    public array $relevantItems;

    /**
     * @var array all incorrect items in the array
     */
    public array $incorrectItems;

    /**
     * @var int quantity all got items
     */
    public int $countAllItems;

    /**
     * @var array headers
     */
    public array $headers;

    /**
     * @var int quantity relevant items
     */
    public int $countRelevantItems;

    /**
     * @var int count incorrect items
     */
    public int $countIncorrectItems;
}
