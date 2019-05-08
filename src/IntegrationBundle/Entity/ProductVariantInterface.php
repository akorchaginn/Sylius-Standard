<?php


namespace IntegrationBundle\Entity;

use Sylius\Component\Core\Model\ProductVariantInterface as BaseProductVariantInterface;

interface ProductVariantInterface extends BaseProductVariantInterface, IntegrationInterface
{

    public function setEnabled(bool $enabled): void;

    public function isEnabled(): bool;
}