<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class to adding data in DB
 */
class AddDataToDb
{
    /**
     * @var EntityManagerInterface
    */
    public EntityManagerInterface $entityManager;

    /**
     * @var ValidatorInterface
    */
    public ValidatorInterface $validator;

    /**
     * @var object
     */
    public object $objFilterData;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function add(object $objFilterData) :object
    {
        $entityManager = $this->entityManager;
        $this->objFilterData = $objFilterData;

        try {
            if (isset($objFilterData) and !empty($objFilterData)) {
                foreach ($this->objFilterData->relevantItems as $kay => $value) {
                    $product = new Product();
                    $product->setProductName($value->productName);
                    $product->setProductDesc($value->productDescription);
                    $product->setProductCode($value->productCode);
                    $product->setAdded(new \DateTime());

                    if ($value->discontinued === 'yes') {
                        $product->setDiscontinued(new \DateTime());
                    }

                    $product->setTimestampDate(new \DateTime());
                    $product->setStock(intval($value->stock));
                    $product->setCost(floatval($value->costInGBP));
                    $errors = $this->validator->validate($product);

                    if (count($errors) > 0) {
                        return new ImportErrorsResult('Notice! data not valid'.PHP_EOL);
                    }

                    $entityManager->persist($product);
                    $entityManager->flush();
                    unset($product);
                }
            }

            return $this->objFilterData;
        } catch (\Exception $exception){

            return new ImportErrorsResult('Notice! Data not add in to DB'.PHP_EOL);
        }
    }
}
