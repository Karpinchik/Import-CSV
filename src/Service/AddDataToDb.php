<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class to adding data in DB
 */
class AddDataToDb
{
    /**
     * @var object
    */
    public object $entityManager;

    /**
     * @var object
    */
    public object $validator;

//    /**
//     * @var object
//    */
//    public object $product;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
//        $this->product = $product;
    }

    public function add(array $arrayFilterData) :bool
    {
        try {
            $entityManager = $this->entityManager;

            if (isset($arrayFilterData) and !empty($arrayFilterData)) {
                foreach ($arrayFilterData['relevantItems'] as $kay => $value) {
                    //сомнительное решение. надо переделать
//                    $product = new Product(
//                        $value['Product Name'],
//                        $value['Product Description'],
//                        $value['Product Code'],
//                        $value['Discontinued'],
//                        $value['Stock'],
//                        $value['Cost in GBP']
//                    );

                    $product = new Product();
                    $product->setProductName($value['Product Name']);
                    $product->setProductDesc($value['Product Description']);
                    $product->setProductCode($value['Product Code']);
                    $product->setAdded(new \DateTime());
                    $product->setDiscontinued(new \DateTime());
                    $product->setTimestampDate(new \DateTime());
                    $product->setStock(intval($value['Stock']));
                    $product->setCost(floatval($value['Cost in GBP']));

                    $errors = $this->validator->validate($product);
                    if (count($errors) > 0) {
                        return false;
                    }

                    $entityManager->persist($product);
                    $entityManager->flush();
                }
            }

            return true;
        } catch (\Exception $exception) {

            return false;
        }
    }
}



