<?php
declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $data = new \DateTime;
        $formMapper
            ->add('productName',  TextType::class)
            ->add('productDesc',  TextType::class)
            ->add('productCode',  TextType::class)
            ->add('added',null, array('data' => $data))
            ->add('discontinued')
            ->add('stock',  IntegerType::class)
            ->add('cost',  MoneyType::class, array('currency' => 'RUB'))
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
