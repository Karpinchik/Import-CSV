<?php

namespace App\Entity;

use App\Repository\ProdRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProdRepository::class)
 */
class Prod
{
    /**
     * @var int
     *
     * @ORM\Column(name="int_product_data_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $intProductDataId;

    /**
     * @var string
     *
     * @ORM\Column(name="str_product_name", type="string", length=50, nullable=false)
     */
    private $strProductName;

    /**
     * @var string
     *
     * @ORM\Column(name="str_product_desc", type="string", length=255, nullable=false)
     */
    private $strProductDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="str_product_code", type="string", length=10, nullable=false)
     */
    private $strProductCode;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="str_discontinued", type="string", length=10, nullable=true)
     */
    private $strDiscontinued;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dtm_discontinued", type="datetime", nullable=true)
     */
    private $dtmDiscontinued;

    /**
     * @var float
     *
     * @ORM\Column(name="flt_cost_gbr", type="float", precision=10, scale=0, nullable=false)
     */
    private $fltCostGbr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stm_timestamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $stmTimestamp = 'CURRENT_TIMESTAMP';

    public function getIntProductDataId(): ?int
    {
        return $this->intProductDataId;
    }

    public function getStrProductName(): ?string
    {
        return $this->strProductName;
    }

    public function setStrProductName(string $strProductName): self
    {
        $this->strProductName = $strProductName;

        return $this;
    }

    public function getStrProductDesc(): ?string
    {
        return $this->strProductDesc;
    }

    public function setStrProductDesc(string $strProductDesc): self
    {
        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    public function getStrProductCode(): ?string
    {
        return $this->strProductCode;
    }

    public function setStrProductCode(string $strProductCode): self
    {
        $this->strProductCode = $strProductCode;

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

    public function getStrDiscontinued(): ?string
    {
        return $this->strDiscontinued;
    }

    public function setStrDiscontinued(?string $strDiscontinued): self
    {
        $this->strDiscontinued = $strDiscontinued;

        return $this;
    }

    public function getDtmDiscontinued(): ?\DateTimeInterface
    {
        return $this->dtmDiscontinued;
    }

    public function setDtmDiscontinued(?\DateTimeInterface $dtmDiscontinued): self
    {
        $this->dtmDiscontinued = $dtmDiscontinued;

        return $this;
    }

    public function getFltCostGbr(): ?float
    {
        return $this->fltCostGbr;
    }

    public function setFltCostGbr(float $fltCostGbr): self
    {
        $this->fltCostGbr = $fltCostGbr;

        return $this;
    }

    public function getStmTimestamp(): ?\DateTimeInterface
    {
        return $this->stmTimestamp;
    }

    public function setStmTimestamp(\DateTimeInterface $stmTimestamp): self
    {
        $this->stmTimestamp = $stmTimestamp;

        return $this;
    }
}
