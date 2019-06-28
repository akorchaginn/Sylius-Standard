<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;

/**
 * Interface ProductInterface
 * @package IntegrationBundle\Entity
 */
interface ProductInterface extends BaseProductInterface, IntegrationInterface
{

}