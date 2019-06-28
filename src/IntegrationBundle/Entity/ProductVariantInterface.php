<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\ProductVariantInterface as BaseProductVariantInterface;

/**
 * Interface ProductVariantInterface
 * @package IntegrationBundle\Entity
 */
interface ProductVariantInterface extends BaseProductVariantInterface, IntegrationInterface
{
    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void;

    /**
     * @return bool
     */
    public function isEnabled(): bool;
}