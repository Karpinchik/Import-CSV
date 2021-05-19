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
        if (null !== $data) {
            $forms = iterator_to_array($forms);

            if($data->getProductDataId()){
                $forms['added']->setData($data->getAdded());
            }
        }
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param Product $data
     */
    public function mapFormsToData($forms, &$data)
    {
        if (null === $data) {
            $forms = iterator_to_array($forms);
            $productName = $forms['productName']->getData();
            $productDesc = $forms['productDesc']->getData();
            $productCode = $forms['productCode']->getData();
            $discontinued = $forms['discontinued']->getData();
            $stock = $forms['stock']->getData();
            $cost = $forms['cost']->getData();
            $data = new Product(  $productName,  $productDesc,  $productCode, $discontinued, $stock,  $cost);
        }
    }
}
