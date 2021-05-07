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
    public array $header;

    /**
     * @var int
     */
    public int $count;

    /**
     * @var array
     */
    public array $allProducts;

    public function __construct($header, $count, $allProducts) {
        $this->header = $header;
        $this->count = $count;
        $this->allProducts = $allProducts;
    }
}
