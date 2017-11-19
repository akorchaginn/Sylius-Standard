<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Sylius\Bundle\CoreBundle\Application\Kernel;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 * @author Gonzalo Vilaseca <gvilaseca@reiss.co.uk>
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new \Sylius\Bundle\AdminBundle\SyliusAdminBundle(),
            new \Sylius\Bundle\ShopBundle\SyliusShopBundle(),

            new \FOS\OAuthServerBundle\FOSOAuthServerBundle(), // Required by SyliusApiBundle
            new \Sylius\Bundle\AdminApiBundle\SyliusAdminApiBundle(),
            
            new \Sylius\ShopApiPlugin\ShopApiPlugin(),
            new \League\Tactician\Bundle\TacticianBundle(),
            
            new \AppBundle\AppBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new \Urbanara\CatalogPromotionPlugin\CatalogPromotionPlugin(),
            new \Sylius\ElasticSearchPlugin\SyliusElasticSearchPlugin(),
            new \ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
            new \ONGR\FilterManagerBundle\ONGRFilterManagerBundle(),
            new \SimpleBus\SymfonyBridge\SimpleBusCommandBusBundle(),
            new \SimpleBus\SymfonyBridge\SimpleBusEventBusBundle(),
            new SitemapPlugin\SitemapPlugin(),
            
            new Lexik\Bundle\MaintenanceBundle\LexikMaintenanceBundle()
        ];

        return array_merge(parent::registerBundles(), $bundles);
    }
}