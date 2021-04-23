<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Serializer\Serializer;
//use Symfony\Component\Serializer\Encoder\CsvEncoder;

//use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



class ReadCsvController extends AbstractController
{

    /** @var $pathCsv string File with CSV */
    protected $pathCsv = null;

// надо перенести в родительский класс, чтобы не dry
    /**
     * @params string $pathCsv
     * @return void
     */
    public function setPathCsv($pathCsv)
    {
        $this->pathCsv = '../../'.$pathCsv;
    }

    public function deserializeFile($pathCsv)
    {
        $dataCsv = file_get_contents($pathCsv);

        $csv = str_getcsv($dataCsv);

//        $encoders = array(new CsvEncoder());
//        $normalizers = array(new ObjectNormalizer());
//        $serializer = new Serializer($normalizers, $encoders);
//        $serializer->deserialize($dataCsv, ????, 'csv');

        return $csv;

    }







}