<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Customer\Model\CustomerInterface as BaseCustomerInterface;

interface CustomerInterface extends BaseCustomerInterface, IntegrationInterface
{

}