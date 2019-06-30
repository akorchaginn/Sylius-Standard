<?php

declare(strict_types=1);

namespace AppBundle\Twig;

use Symfony\Component\Templating\Helper\Helper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class MinPriceVariantExtension extends AbstractExtension
{
    /** @var Helper */
    private $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('marinewool_resolve_min_price_variant', [$this->helper, 'resolveVariant']),
        ];
    }
}