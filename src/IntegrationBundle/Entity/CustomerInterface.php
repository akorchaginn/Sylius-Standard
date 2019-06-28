<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Customer\Model\CustomerInterface as BaseCustomerInterface;

/**
 * Interface CustomerInterface
 * @package IntegrationBundle\Entity
 */
interface CustomerInterface extends BaseCustomerInterface, IntegrationInterface
{

}