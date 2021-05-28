<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClearTmpUploadFiles extends AbstractController
{
    /**
     * @param $fullPathUploadDir
     */
    public function clearUploadFiles($fullPathUploadDir) :void
    {
        $files = glob($fullPathUploadDir.'/*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }
    }
}
