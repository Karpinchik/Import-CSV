<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="Product", uniqueConstraints={@ORM\UniqueConstraint(name="ProductData_ProductCode_uindex", columns={"ProductCode"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 *
 * @UniqueEntity("productCode")
 */
final class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="ProductDataId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $productDataId;

    /**
     * @var string
     *
     * @ORM\Column(name="ProductName", type="string", length=50, nullable=false)
     */
    protected string $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="ProductDesc", type="string", length=255, nullable=false)
     */
    protected string $productDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="ProductCode", type="string", length=10, nullable=false, unique=true)
     */
    protected string $productCode;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Added", type="datetime", nullable=true)
     */
    protected ?\DateTime $added;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Discontinued", type="datetime", nullable=true)
     */
    protected ?\DateTime $discontinued;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="TimestampDate", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    protected \DateTime $timestampDate;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    protected int $stock;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float", precision=10, scale=0, nullable=false)
     */
    protected float $cost;

    /**
     * Product constructor.
     * @param string $productName
     * @param string $productDesc
     * @param string $productCode
     * @param \DateTime|object|null $discontinued
     * @param int $stock
     * @param float $cost
     */
    public function __construct( string $productName, string $productDesc, string $productCode, $discontinued, int $stock, float $cost)
    {
        $this->productName = $productName;
        $this->productDesc = $productDesc;
        $this->productCode = $productCode;
        $this->added = new \DateTime();
        $this->discontinued = $discontinued;
        $this->timestampDate = new \DateTime();
        $this->stock = $stock;
        $this->cost = $cost;
    }

    public function getProductDataId(): ?int
    {
        return $this->productDataId;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDesc(): ?string
    {
        return $this->productDesc;
    }

    public function setProductDesc(string $productDesc): self
    {
        $this->productDesc = $productDesc;

        return $this;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $productCode): self
    {
        $this->productCode = $productCode;

        return $this;
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

    public function setAdded(?\DateTimeInterface $added): self
    {
        $this->added = $added;

        return $this;
    }

    public function getDiscontinued(): ?\DateTimeInterface
    {
        return $this->discontinued;
    }

    public function setDiscontinued(?\DateTimeInterface $discontinued): self
    {
        $this->discontinued = $discontinued;

        return $this;
    }

    public function getTimestampDate(): ?\DateTimeInterface
    {
        return $this->timestampDate;
    }

    public function setTimestampDate(\DateTimeInterface $timestampDate): self
    {
        $this->timestampDate = $timestampDate;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
