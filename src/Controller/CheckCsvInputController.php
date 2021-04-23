<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CheckCsvInputController extends AbstractController
{
    /** @type string File with CSV */
    protected $pathCsv = null;

    /**
     * Set name file to properties
     *
     * @params string $pathCsv
     *
     * @return void
     */
    public function setPathCsv($pathCsv)
    {
        $this->pathCsv = $pathCsv;
    }

    /**
     * Check format the file
     *
     * @param string $pathCsv
     *
     * @return integer
     */
    public function checkFormat($pathFile)
    {
        $ext = mb_strtolower(pathinfo($this->pathCsv , PATHINFO_EXTENSION));

        if(isset($ext) && $ext == 'csv') {
            return 1;
        } else {
            return 0;
        }

    }

}