<?php
declare(strict_types=1);

namespace App\Service;

use League\Csv\Reader;
/**
 * Deserialize csv in to array
*/
class ReadCsv
{
    /**
     * @var array
    */
    private array $arrayAllItems;
    /**
     * @param string $pathFile
     * @return array
    */
    public function deserializeFile(string $pathFile): array
    {
        try {
            $csv = Reader::createFromPath($pathFile, 'r');
            $csv->setHeaderOffset(0);
            $header = $csv->getHeader();
            $records = $csv->getRecords();
            $count = $csv->count();
            $this->arrayAllItems['header'] = $header;
            $this->arrayAllItems['count'] = $count;

            foreach ($records as $key => $record) {
                $this->arrayAllItems['All products'][$record['Product Code']] = $record;
            }

            return $this->arrayAllItems;
        } catch (\Exception $exception){
            $this->arrayAllItems['error'] = 'error';

            return $this->arrayAllItems;
        }
    }
}
