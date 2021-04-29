<?php
declare(strict_types=1);

namespace App\Service;

/**
 * To check format the input file. The should be - .csv
 */
class CheckCsv
{
    /**
     * Check format the file
     *
     * @param string $pathFile
     * @return integer
     */
    public function checkFormat(string $pathFile) :int
    {
        $ext = mb_strtolower(pathinfo($pathFile , PATHINFO_EXTENSION));
        if(isset($ext) && $ext == 'csv') {
            return 1;
        } else {
            return 0;
        }
    }
}