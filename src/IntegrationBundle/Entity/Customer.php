<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\Customer as ParentCustomer;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 * @package IntegrationBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends ParentCustomer implements CustomerInterface
{
    use IntegrationTrait;
}