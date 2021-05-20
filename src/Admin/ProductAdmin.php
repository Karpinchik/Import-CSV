<?php
declare(strict_types=1);

namespace App\Admin;

use App\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\CallbackTransformer;

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
        $dataNow = new \DateTime();
        $formMapper
            ->with('Product information', [ 'class' => 'col-md-8'])
                ->add('productName',  TextType::class, array('help' => 'Enter product name'))
                ->add('productCode',  TextType::class, array('help' => 'Enter product code'))
                ->add('productDesc',  TextareaType::class, array('help' => 'Enter product description'))
            ->end()
            ->with('Product data', [ 'class' => 'col-md-8'])
                ->add('added')
            ->add('discontinued', ChoiceFieldMaskType::class, [
                'choices' => [
                    'yes' => $dataNow,
                    'no' => null,
                ]
            ])
            ->end()
            ->with('Product characteristics', [ 'class' => 'col-md-8'])
                ->add('stock',  IntegerType::class, array('help' => 'Enter stock'))
                ->add('cost',  MoneyType::class, array('currency' => 'RUB', 'help' => 'Enter cost product'))
            ->end()
        ;

        $formMapper->get('added')
            ->addModelTransformer(new CallbackTransformer(
                function () use ($dataNow){
                    return $dataNow;
                },
                function () use ($dataNow) {
                    return $dataNow;
                }
            ));
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
            ->add('cost')
        ;
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
            ->addIdentifier('discontinued')
            ->addIdentifier('stock')
            ->addIdentifier('cost')
        ;
    }
}
