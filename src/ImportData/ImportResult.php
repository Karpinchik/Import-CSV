<?php
declare(strict_types=1);

namespace App\ImportData;

/**
 * Class ImportResult
 * @package App\ImportData
 */
class ImportResult
{
    /**
     * @var array all relevant items in the array
     */
    private array $relevantItems;

    /**
     * @var array all incorrect items in the array
     */
    private array $incorrectItems;

    /**
     * @var int quantity all got items
     */
    private int $countAllItems;

    /**
     * @var array headers
     */
    private array $headers;

    /**
     * @var int quantity relevant items
     */
    private int $countRelevantItems;

    /**
     * @var int count incorrect items
     */
    private int $countIncorrectItems;

    /**
     * ImportResult constructor.
     * @param $relevantItems
     * @param $incorrectItems
     * @param $countAllItems
     * @param $headers
     * @param $countRelevantItems
     * @param $countIncorrectItems
     */
    public function __construct($relevantItems, $incorrectItems, $countAllItems, $headers, $countRelevantItems, $countIncorrectItems) {
        $this->relevantItems = $relevantItems;
        $this->incorrectItems = $incorrectItems;
        $this->countAllItems = $countAllItems;
        $this->headers = $headers;
        $this->countRelevantItems = $countRelevantItems;
        $this->countIncorrectItems = $countIncorrectItems;
    }

    /**
     * @return array
     */
    public function getRelevantItems(): array
    {
        return $this->relevantItems;
    }

    /**
     * @param array $relevantItems
     */
    public function setRelevantItems(array $relevantItems): void
    {
        $this->relevantItems[] = $relevantItems;
    }

    /**
     * @return array
     */
    public function getIncorrectItems(): array
    {
        return $this->incorrectItems;
    }

    /**
     * @param array $incorrectItems
     */
    public function setIncorrectItems(array $incorrectItems): void
    {
        $this->incorrectItems[] = $incorrectItems;
    }

    /**
     * @return int
     */
    public function getCountAllItems(): int
    {
        return $this->countAllItems;
    }

    /**
     * @param int $countAllItems
     */
    public function setCountAllItems(int $countAllItems): void
    {
        $this->countAllItems = $countAllItems;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getCountRelevantItems(): int
    {
        return $this->countRelevantItems;
    }

    /**
     * @param int $countRelevantItems
     */
    public function setCountRelevantItems(int $countRelevantItems): void
    {
        $this->countRelevantItems = $countRelevantItems;
    }

    /**
     * @return int
     */
    public function getCountIncorrectItems(): int
    {
        return $this->countIncorrectItems;
    }

    /**
     * @param int $countIncorrectItems
     */
    public function setCountIncorrectItems(int $countIncorrectItems): void
    {
        $this->countIncorrectItems = $countIncorrectItems;
    }
}
