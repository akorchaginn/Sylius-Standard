<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Product\Model\ProductVariantInterface as BaseProductVariantInterface;

interface ProductVariantInterface extends BaseProductVariantInterface, IntegrationInterface
{

}