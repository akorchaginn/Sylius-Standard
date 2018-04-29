<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ImageBundle\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener {
    /**
     * @param MenuBuilderEvent $event
     */
     public function addAdminMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $newsMenu = $menu
                ->addChild('gallery')
                ->setLabel('image.ui.main')
        ;
        $newsMenu
                ->addChild('slide', ['route' => 'image_admin_slide_index'])
                ->setLabel('image.ui.image')
                ->setLabelAttribute('icon', 'newspaper')                                
        ;
        $newsMenu
                ->addChild('cache', ['route' => 'image_admin_slide_index'])
                ->setLabel('image.ui.cache')
                ->setLabelAttribute('icon', 'newspaper')                                
        ;        
    }
}
