<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 10.04.2019
 * Time: 15:22
 */

namespace IntegrationBundle\Model;

use Doctrine\ORM\EntityManager;

/**
 * Class Factory
 * @package IntegrationBundle\Model
 */
class Factory
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Factory constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @return Customer
     */
    public function createCustomer()
    {
        $customer = new Customer();

        return $customer;
    }

    /**
     * @return ProductVariant
     */
    public function createProductVariant()
    {
        $productVariant = new ProductVariant();

        return $productVariant;
    }

    /**
     * @return Product
     */
    public function createProduct()
    {
        $product = new Product();

        return $product;
    }
}