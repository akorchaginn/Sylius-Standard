<?php

namespace ImageBundle\Form\Type;

/**
 * Description of SlideImageType
 *
 * @author akorchagin
 */

use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

final class SlideImageType extends ImageType{
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'slide_image';
    }
}
