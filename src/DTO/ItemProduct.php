<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ItemProduct
 * @package App\DTO
 */
class ItemProduct
{
    /**
     * @Assert\Type("string")
     */
    private string $productCode;

    /**
     * @Assert\Type("string")
     */
    private string $productName;

    /**
     * @Assert\Type("string")
     */
    private string $productDescription;

    /**
     * @Assert\GreaterThan(9)
     * @Assert\Positive()
     */
    private int $stock;

    /**
     * @Assert\Type("float")
     * @Assert\Positive()
     * @Assert\LessThan(999.99)
     * @Assert\GreaterThan(4.99)
     */
    private float $costInGBP;

    /**
     * @Assert\Type("string")
     */
    private string $discontinued;

    public function __construct($productCode, $productName, $productDescription, $stock, $costInGBP, $discontinued) {
        $this->productCode = $productCode;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->stock = $stock;
        $this->costInGBP = $costInGBP;
        $this->discontinued = $discontinued;
    }

    /**
     * @return string
     */
    public function getProductCode(): string
    {
        return $this->productCode;
    }

    /**
     * @param string $productCode
     */
    public function setProductCode(string $productCode): void
    {
        $this->productCode = $productCode;
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getProductDescription(): string
    {
        return $this->productDescription;
    }

    /**
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription): void
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return float
     */
    public function getCostInGBP(): float
    {
        return $this->costInGBP;
    }

    /**
     * @param float $costInGBP
     */
    public function setCostInGBP(float $costInGBP): void
    {
        $this->costInGBP = $costInGBP;
    }

    /**
     * @return string
     */
    public function getDiscontinued(): string
    {
        return $this->discontinued;
    }

    /**
     * @param string $discontinued
     */
    public function setDiscontinued(string $discontinued): void
    {
        $this->discontinued = $discontinued;
    }

}