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
    private EntityManagerInterface $entityManager;

    /**
     * @var ValidatorInterface
    */
    private ValidatorInterface $validator;

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
                    $product->setProductName($value['Product Name']);
                    $product->setProductDesc($value['Product Description']);
                    $product->setProductCode($value['Product Code']);
                    $product->setAdded(new \DateTime());

                    if ($value['Discontinued'] === 'yes') {
                        $product->setDiscontinued(new \DateTime());
                    }

                    $product->setTimestampDate(new \DateTime());
                    $product->setStock(intval($value['Stock']));
                    $product->setCost(floatval($value['Cost in GBP']));
                    $errors = $this->validator->validate($product);

                    if (count($errors) > 0) {
                        return new ImportErrorsResult('данные не прошли валидацию при записи в БД');
                    }

                    $entityManager->persist($product);
                    $entityManager->flush();
                    unset($product);
                }
            }

            return $this->objFilterData;
        } catch (\Exception $exception){

            return new ImportErrorsResult('data not add in to DB');
        }
    }
}
