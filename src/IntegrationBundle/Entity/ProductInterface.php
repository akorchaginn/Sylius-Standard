<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Product\Model\ProductInterface as BaseProductInterface;

interface ProductInterface extends BaseProductInterface, IntegrationInterface
{

}