<?php
declare(strict_types=1);

namespace App\Service;

use League\Csv\Reader;

/**
 * Deserialize csv in to object
 *
 * Class ReadCsv
 * @package App\Service
 */
class ReadCsv
{
    /**
     * @var AllItemsBeforeRead object
     */
    protected AllItemsBeforeRead $allItems;

    /**
     * @var array
     */
    public array $arrayAllItems;

    /**
     * @var ItemProduct
     */
    public ItemProduct $itemProduct;

    /**
     * @param string $pathFile
     * @return AllItemsBeforeRead
     *
     * @throws \Exception
     */
    public function deserializeFile(string $pathFile): AllItemsBeforeRead
    {
        try {
            $this->allItems = new AllItemsBeforeRead();
            $csv = Reader::createFromPath($pathFile, 'r');
            $csv->setHeaderOffset(0);
            $this->allItems->header = $csv->getHeader();
            $records = $csv->getRecords();
            $this->allItems->count = $csv->count();

            foreach ($records as $key => $record) {
                $this->itemProduct = new ItemProduct();
                $this->itemProduct->productCode = $record['Product Code'];
                $this->itemProduct->productName = $record['Product Name'];
                $this->itemProduct->productDescription = $record['Product Description'];
                $this->itemProduct->stock = intval($record['Stock']);
                $this->itemProduct->costInGBP = floatval($record['Cost in GBP']);
                $this->itemProduct->discontinued = strval($record['Discontinued']);
                $this->allItems->allProducts[$record['Product Code']] = $this->itemProduct;
            }

            return $this->allItems;
        } catch (\Exception $exception){
            throw new \Exception('Notice! Not read file'.PHP_EOL);
        }
    }
}
