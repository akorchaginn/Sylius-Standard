<?php
/**
 * Created by PhpStorm.
 * User: akorc_000
 * Date: 25.12.2018
 * Time: 8:03
 */

namespace ReportBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $newsMenu = $menu
            ->addChild('reports')
            ->setLabel('sylius.ui.reports')
        ;
        $newsMenu
            ->addChild('income', ['route' => 'income_show'])
            ->setLabel('sylius.report.income')
            ->setLabelAttribute('icon', 'shopping-basket')
        ;
        $newsMenu
            ->addChild('grossProfit', ['route' => 'gross_profit_show'])
            ->setLabel('sylius.ui.grossProfit')
            ->setLabelAttribute('icon', 'ruble-sign')
        ;
        $newsMenu
            ->addChild('commodityBalance', ['route' => 'commodity_balance_show'])
            ->setLabel('sylius.ui.commodityBalance')
            ->setLabelAttribute('icon', 'stocking')
        ;
    }
}

