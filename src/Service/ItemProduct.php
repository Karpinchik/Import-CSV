<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ItemProduct
 * @package App\Service
 */
class ItemProduct
{
    /**
     * @Assert\Type("string")
     */
    public string $productCode;

    /**
     * @Assert\Type("string")
     */
    public string $productName;

    /**
     * @Assert\Type("string")
     */
    public string $productDescription;

    /**
     * @Assert\GreaterThan(9)
     * @Assert\Positive()
     */
    public int $stock;

    /**
     * @Assert\Type("float")
     * @Assert\Positive()
     * @Assert\LessThan(999.99)
     * @Assert\GreaterThan(4.99)
     */
    public float $costInGBP;

    /**
     * @Assert\Type("string")
     */
    public string $discontinued;
}