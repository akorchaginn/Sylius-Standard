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
     * @param bool|null $enabled
     */
    public function setEnabled(?bool $enabled): void;

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool;
}