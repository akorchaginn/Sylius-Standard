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

    /**
     * @return Order
     */
    public function createOrder()
    {
        $order = new Order();

        return $order;
    }

    /**
     * @return Shipping
     */
    public function createShipping()
    {
        $shipping = new Shipping();

        return $shipping;
    }

    /**
     * @return OrderItem
     */
    public function createOrderItem()
    {
        $orderItem = new OrderItem();

        return $orderItem;
    }

    /**
     * @return Payment
     */
    public function createPayment()
    {
        $payment = new Payment();

        return $payment;
    }

    /**
     * @return Attribute
     */
    public function createAttribute()
    {
        $attribute = new Attribute();

        return $attribute;
    }
}