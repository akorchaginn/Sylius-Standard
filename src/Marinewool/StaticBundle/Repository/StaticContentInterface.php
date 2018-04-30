<?php

namespace Marinewool\StaticBundle\Repository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sylius\Component\Resource\Repository\RepositoryInterface as RI;

interface StaticContentInterface extends RI {
    
    /**
     * @param string $slug
     * 
     * @return StaticContentInterface|null
     */
    public function findOneBySlug($slug);
}
