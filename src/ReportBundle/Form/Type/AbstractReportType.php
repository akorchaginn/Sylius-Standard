<?php
/**
 * Created by PhpStorm.
 * User: akorchagin
 * Date: 29.12.2018
 * Time: 21:14
 */

namespace ReportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AbstractReportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $date = new \DateTime();

        $now = clone $date;
        $yearAgo = $date->modify('-1 year');

        $builder->add('date_from', DateTimeType::class, [
            'required' => true,
            'label' => 'sylius.ui.start_date',
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
            'data'       =>  $yearAgo->setTime(0,0, 0),
        ])->add('date_to', DateTimeType::class, [
            'required' => true,
            'label' => 'sylius.ui.end_date',
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
            'data'       =>  $now->modify('-1day')->setTime(23,59,59),
        ])->add('submit', SubmitType::class, [
            'label' => 'sylius.report.apply',
            'attr' => [
                'class' => 'ui labeled icon button  primary'
            ]
        ]);
    }
}