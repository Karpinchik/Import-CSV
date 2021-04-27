<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Prod;
use Doctrine\ORM\EntityManagerInterface;


class AddDataToDb
{
// тестовая запись в базу
    public function add(){

        $entityManager = $this->getDoctrine()->getManager();
        $product = new Prod();
        $product->setStrProductName('Bluray Player');
        $product->setStrProductCode('P0028');
        $product->setStrProductDesc("Plays bluray's");
        $product->setStock(32);
        $product->setStrDiscontinued('yes');
        $product->setDtmDiscontinued();
        $product->setFltCostGbr(1100.04);

        $entityManager->persist($product);
        $entityManager->flush();

        return 'Success. The products added in to DB';
    }
}



