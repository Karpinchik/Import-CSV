<?php
declare(strict_types=1);

namespace App\ImportData;

/**
 * Class AllItemsAfterRead
 * @package App\ImportData
 */
class AllItemsAfterRead
{
    /**
     * @var array
     */
    private array $header;

    /**
     * @var int
     */
    private int $count;

    /**
     * @var array
     */
    private array $allProducts;

    /**
     * AllItemsAfterRead constructor.
     * @param $header
     * @param $count
     * @param $allProducts
     */
    public function __construct($header, $count, $allProducts) {
        $this->header = $header;
        $this->count = $count;
        $this->allProducts = $allProducts;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     */
    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return array
     */
    public function getAllProducts(): array
    {
        return $this->allProducts;
    }

    /**
     * @param array $allProducts
     */
    public function setAllProducts(array $allProducts): void
    {
        $this->allProducts = $allProducts;
    }
}
