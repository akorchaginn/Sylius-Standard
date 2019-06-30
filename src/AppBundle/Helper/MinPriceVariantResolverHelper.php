<?php

declare(strict_types=1);

namespace AppBundle\Helper;

use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\Component\Product\Resolver\ProductVariantResolverInterface;
use Symfony\Component\Templating\Helper\Helper;

final class MinPriceVariantResolverHelper extends Helper
{
    /** @var ProductVariantResolverInterface */
    private $productVariantResolver;

    public function __construct(ProductVariantResolverInterface $productVariantResolver)
    {
        $this->productVariantResolver = $productVariantResolver;
    }

    public function resolveVariant(ProductInterface $product): ?ProductVariantInterface
    {
        return $this->productVariantResolver->getVariant($product);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'marinewool_resolve_min_price_variant';
    }
}