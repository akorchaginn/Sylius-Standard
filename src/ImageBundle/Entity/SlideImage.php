<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ImageBundle\Entity;

/**
 * Description of SlideImage
 *
 * @author akorchagin
 */
use Sylius\Component\Core\Model\Image;
use Doctrine\ORM\Mapping as ORM;


/**
 * SlideImage
 *
 * @ORM\Table(name="slide_image")
 * @ORM\Entity
 */
class SlideImage extends Image
{
    
    /**
     * @var object
     * @ORM\ManyToOne(targetEntity="ImageBundle\Entity\Slide", inversedBy="images")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $owner;
}
