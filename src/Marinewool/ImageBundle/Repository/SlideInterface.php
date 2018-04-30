<?php

namespace Marinewool\ImageBundle\Repository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sylius\Component\Resource\Repository\RepositoryInterface as RI;

interface SlideInterface extends RI {
    
    /**
     * @return SlideInterface|null
     */
    
    public function getSlides();
}
