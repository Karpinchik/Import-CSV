<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Validator\Validation;

/**
 * Class ValidatorProduct
 * @package App\Validator
 */
class ValidatorProduct
{
    /**
     * @var \Symfony\Component\Validator\Validator\RecursiveValidator|\Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected $getValidatorProduct;

    /**
     * ValidatorProduct constructor.
     */
    public function __construct()
    {
        $this->getValidatorProduct = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }

    /**
     * @return \Symfony\Component\Validator\Validator\RecursiveValidator|\Symfony\Component\Validator\Validator\ValidatorInterface
     */
    public function getValidatorProduct()
    {
        return $this->getValidatorProduct;
    }
}