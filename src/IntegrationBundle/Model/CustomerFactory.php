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
 * Class CustomerFactory
 * @package IntegrationBundle\Model
 */
class CustomerFactory
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CustomerFactory constructor.
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
}