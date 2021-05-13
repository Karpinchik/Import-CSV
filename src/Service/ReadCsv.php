<?php
declare(strict_types=1);

namespace App\Service;

use App\DTO\ItemProduct;
use App\ImportData\AllItemsAfterRead;
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
     * Deserialize csv in to object
     *
     * @param string $pathFile
     * @return AllItemsAfterRead
     * @throws \Exception
     */
    public function deserializeFile(string $pathFile): AllItemsAfterRead
    {
        $arrayAllItems = [];
        $csv = Reader::createFromPath($pathFile, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $key => $record) {
            $itemProduct = new ItemProduct(
                $record['Product Code'],
                $record['Product Name'],
                $record['Product Description'],
                intval($record['Stock']),
                floatval($record['Cost in GBP']),
                strval($record['Discontinued'])
            );
            $arrayAllItems[$record['Product Code']] = $itemProduct;
            unset($itemProduct);
        }

        return new AllItemsAfterRead($csv->getHeader(), $csv->count(), $arrayAllItems);
    }
}
