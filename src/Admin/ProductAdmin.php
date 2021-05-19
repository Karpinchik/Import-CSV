<?php
declare(strict_types=1);

namespace App\Admin;

use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object instanceof Product
            ? $object->getProductName()
            : 'Product';
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $data = new \DateTime;
        $formMapper
            ->add('productName',  TextType::class, array('help' => 'Enter product name'))
            ->add('productDesc',  TextType::class, array('help' => 'Enter product description'))
            ->add('productCode',  TextType::class, array('help' => 'Enter product code'))
            ->add('added',null, array('data' => $data))
            ->add('discontinued', null, array('help' => 'Enter data if product discontinued'))
            ->add('stock',  IntegerType::class, array('help' => 'Enter stock. This value should be not less than 10'))
            ->add('cost',  MoneyType::class, array('currency' => 'RUB', 'help' => 'Enter cost product. 
            This value should be greater than 5 and less then 1000'))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('productName')
            ->add('productCode')
            ->add('added')
            ->add('stock')
            ->add('cost')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('productName')
            ->addIdentifier('productDesc')
            ->addIdentifier('productCode')
            ->addIdentifier('discontinued')
            ->addIdentifier('stock')
            ->addIdentifier('cost')
        ;
    }
}
