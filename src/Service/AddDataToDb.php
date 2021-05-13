<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\ImportData\ImportResult;

/**
 * Class to adding data in DB
 *
 * Class AddDataToDb
 * @package App\Service
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
     * AddDataToDb constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * Add data in to DB
     * @param ImportResult $objFilterData
     * @return ImportResult
     */
    public function add(ImportResult $objFilterData) :ImportResult
    {
        $entityManager = $this->entityManager;
        $repository = $entityManager->getRepository(Product::class);

        if (isset($objFilterData) and !empty($objFilterData)) {
            foreach ($objFilterData->getRelevantItems() as $kay => $value) {

                $newProduct = $repository->findOneBy(['productCode'=>$value->getProductCode()]);

                if (!($newProduct)) {
                    if ($value->getDiscontinued() === 'yes') {
                        $dataTimeDiscontinued = new \DateTime();
                    } else {
                        $dataTimeDiscontinued = null;
                    }

                    $product = new Product(
                        $value->getProductName(),
                        $value->getProductDescription(),
                        $value->getProductCode(),
                        $dataTimeDiscontinued,
                        $value->getStock(),
                        $value->getCostInGBP()
                    );

                    $entityManager->persist($product);
                    $entityManager->flush();
                    unset($product);
                } else {
                    $entityManager->flush();
                }
            }
        }

        return $objFilterData;
    }
}
