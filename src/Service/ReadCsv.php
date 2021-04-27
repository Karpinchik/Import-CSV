<?php
declare(strict_types=1);

namespace App\Service;

use League\Csv\Reader;

class ReadCsv
{
    /**
     * Deserialize csv to array
     *
     * @param string $fileCSv
     *
     * @return array
    */
    public function deserializeFile(string $fileCSv)
    {
        $csv = Reader::createFromPath($fileCSv, 'r');
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader();
        $records = $csv->getRecords();
        $count = $csv->count();
        $arrayAllItems['header'] = $header;
        $arrayAllItems['count'] = $count;

        foreach ($records as $offset => $record) {
            $arrayAllItems['All products'][$record['Product Code']] = $record;
        }

        return $arrayAllItems;
    }
}