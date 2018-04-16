<?php

namespace Common\AppBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;


class StateMachineFilterType extends AbstractType {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {   
            $builder->add(
                'state',
                ChoiceType::class,
                ['choices' => array(
                    'sylius.ui.all' => '',
                    'sylius.ui.new' => 'new',
                    'sylius.ui.reopen' => 'reopen',                    
                    'sylius.ui.fulfill' => 'fulfilled'
                ),
                 'label' => false]
            );
        }    
}