<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\ProductVariant as ParentProductVariant;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductVariant
 * @package IntegrationBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_variant")
 */
class ProductVariant extends ParentProductVariant implements ProductVariantInterface
{
    use IntegrationTrait;
}