<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\Order as ParentOrder;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package IntegrationBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sylius_order")
 */
class Order extends ParentOrder implements OrderInterface
{
    use IntegrationTrait;
}