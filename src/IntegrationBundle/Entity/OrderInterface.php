<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;

/**
 * Interface OrderInterface
 * @package IntegrationBundle\Entity
 */
interface OrderInterface extends BaseOrderInterface, IntegrationInterface
{

}