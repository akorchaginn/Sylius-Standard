<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;

interface OrderInterface extends BaseOrderInterface, IntegrationInterface
{

}