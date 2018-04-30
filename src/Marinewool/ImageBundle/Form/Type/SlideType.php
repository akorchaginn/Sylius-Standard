<?php

/**
 * Description of SlideType
 *
 * @author akorchagin
 */

namespace Marinewool\ImageBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Marinewool\ImageBundle\Form\Type\SlideImageType;

final class SlideType extends AbstractResourceType {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('url', UrlType::class, [
                    'required' => true,
                    'label' => 'image.ui.url',
                    'default_protocol' => 'https',
                    ]
                )->add('alt', TextType::class, [
                    'required' => true,
                    'label' => 'image.ui.alt',
                    ]
                )->add('description', TextType::class, [
                    'required' => true,
                    'label' => 'sylius.ui.description',
                    ]
                )->add('position', IntegerType::class, [
                    'required' => true,
                    'label' => 'sylius.ui.position',
                    ]
                )->add('date_start', DateTimeType::class, [
                    'required' => true,
                    'label' => 'sylius.ui.start_date',
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',            
                    ]
                )->add('date_finish', DateTimeType::class, [
                    'required' => true,
                    'label' => 'sylius.ui.end_date',
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                    ]
                )->add('enabled', CheckboxType::class, [
                    'required' => true,
                    'label' => 'sylius.ui.is_enabled'
                    ]
                )->add('images', CollectionType::class, [
                    'entry_type' => SlideImageType::class,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'by_reference' => false,
                    'label' => 'image.ui.slide',
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'slide';
    }
}
