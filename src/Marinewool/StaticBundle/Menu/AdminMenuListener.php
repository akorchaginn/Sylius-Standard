<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Marinewool\StaticBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener {
    /**
     * @param MenuBuilderEvent $event
     */
     public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $newsMenu = $menu
                ->addChild('new')
                ->setLabel('app.ui.cms')
        ;

        $newsMenu
                ->addChild('news', ['route' => 'app_admin_news_index'])
                ->setLabel('app.ui.uncost')
                ->setLabelAttribute('icon', 'newspaper')
        ;
        $newsMenu
                ->addChild('static', ['route' => 'app_admin_static_content_index'])
                ->setLabel('app.ui.static_content')
                ->setLabelAttribute('icon', 'newspaper')                                
        ;
    }
}
