<?php
declare(strict_types=1);

namespace App\Service;


class CheckCsv
{
    /**
     * Check format the file
     *
     * @param string $pathCsv
     * @return integer
     */
    public function checkFormat(string $pathFile)
    {
        $ext = mb_strtolower(pathinfo($pathFile , PATHINFO_EXTENSION));

        if(isset($ext) && $ext == 'csv') {
            return 1;
        } else {
            return 0;
        }
    }
}