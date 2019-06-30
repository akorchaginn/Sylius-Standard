<?php

declare(strict_types=1);

namespace AppBundle\Resolver;

use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;

final class MinPriceProductVarantResolver implements ProductVariantResolverInterface
{
    /**
     * {@inheritDoc}
     */
    public function getVariant(ProductInterface $subject): ?ProductVariantInterface
    {
        if ($subject->getVariants()->isEmpty()) {
            return null;
        }

        $minPriceObject = $subject->getVariants()->first();
        $minPrice = 1000000;
        foreach ($subject->getVariants() as $variant)
        {
            if ($variant->getChannelPricings()->first()->getPrice() < $minPrice and !($variant->getChannelPricings()->first()->getPrice() == 0))
            {
                $minPrice = $variant->getChannelPricings()->first()->getPrice();
                $minPriceObject = $variant;
            }
        }

        return $minPriceObject;
    }
}