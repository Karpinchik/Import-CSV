<?php
declare(strict_types=1);

namespace App\Service;

/**
 * To check format the input file. The should be - .csv
 *
 * Class CheckCsv
 * @package App\Service
 */
class CheckCsv
{
    /**
     * Check format the file
     *
     * @param string $pathFile
     * @return bool
     */
    public function checkFormat(string $pathFile) :bool
    {
        $ext = mb_strtolower(pathinfo($pathFile , PATHINFO_EXTENSION));
        if (isset($ext) && $ext == 'csv') {

            return true;
        } else {

            return false;
        }
    }
}
