<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\Product as ParentProduct;


/**
 * Class Product
 * @package IntegrationBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends ParentProduct implements ProductInterface
{
    use IntegrationTrait;
}