<?php
declare(strict_types=1);

namespace App\Admin;

use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


/**
 * Class ProductAdmin
 * @package App\Admin
 */
class ProductAdmin extends AbstractAdmin
{
    /**
     * @param object $object
     * @return string
     */
    public function toString(object $object): string
    {
        return $object instanceof Product
            ? $object->getProductName()
            : 'Product';
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Product information', ['class' => 'col-md-8'])
                ->add('productName', TextType::class, array('help' => 'Enter product name'))
                ->add('productCode', TextType::class, array('help' => 'Enter product code'))
                ->add('productDesc', TextareaType::class, array('help' => 'Enter product description'))
            ->end()
            ->with('Prod', ['class' => 'visible-print-block'])
                ->add('addedFlag', ChoiceType::class, array(
                    'choices' => [
                        'yes' => 1
                    ]
                ))
            ->end()
            ->with('Product data', ['class' => 'col-md-8'])
                ->add('discontinuedFlag', ChoiceType::class, array(
                    'choices' => [
                        'yes' => 1,
                        'no' => 0,
                    ]
                ))
            ->end()
            ->with('Product characteristics', ['class' => 'col-md-8'])
                ->add('stock', IntegerType::class, array('help' => 'Enter stock'))
                ->add('cost', MoneyType::class, array('currency' => 'RUB', 'help' => 'Enter cost product'))
            ->end();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('productName')
            ->add('productCode')
            ->add('added')
            ->add('stock')
            ->add('cost');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('productName')
            ->addIdentifier('productDesc')
            ->addIdentifier('productCode')
            ->addIdentifier('added')
            ->addIdentifier('discontinued')
            ->addIdentifier('stock')
            ->addIdentifier('cost');
    }
}
