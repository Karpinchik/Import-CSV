<?php
declare(strict_types=1);

namespace App\Form\DataMapping;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use App\Entity\Product;

class ProductDataMapper implements DataMapperInterface
{
    /**
     * @param Product $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        $dateNow = new \DateTime();
        if ($data !== null) {
            $forms = iterator_to_array($forms);
            $forms['productName']->setData($data->getProductName());
            $forms['productCode']->setData($data->getProductCode());
            $forms['productDesc']->setData($data->getProductDesc());
            $forms['added']->setData($data->getAdded());
            $forms['discontinued']->setData($data->getDiscontinued());
            $forms['stock']->setData($data->getStock());
            $forms['cost']->setData($data->getCost());
        }
        else {
            $forms['added']->setData($dateNow);
            $forms['discontinued']->setData($dateNow);
        }
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param Product $data
     */
    public function mapFormsToData($forms, &$data)
    {
        if ($data === null) {
            $forms = iterator_to_array($forms);
            $productName = $forms['productName']->getData();
            $productDesc = $forms['productDesc']->getData();
            $productCode = $forms['productCode']->getData();
            $discontinued = $forms['discontinued']->getData();
            $stock = $forms['stock']->getData();
            $cost = $forms['cost']->getData();
            $data = new Product($productName,  $productDesc,  $productCode, $discontinued, $stock,  $cost);
        } else {
            $forms = iterator_to_array($forms);
            $data->update($forms);
        }
    }
}
