<?php

declare(strict_types=1);

namespace Override\AddressingBundle\Form\Type;

use Sylius\Bundle\AddressingBundle\Form\Type\CountryCodeChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddressType
 * @package Override\AddressingBundle\Form\Type
 */
final class AddressType extends AbstractResourceType
{
    /** @var EventSubscriberInterface */
    private $buildAddressFormSubscriber;

    /**
     * @param string[] $validationGroups
     */
    public function __construct(string $dataClass, array $validationGroups, EventSubscriberInterface $buildAddressFormSubscriber)
    {
        parent::__construct($dataClass, $validationGroups);

        $this->buildAddressFormSubscriber = $buildAddressFormSubscriber;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'sylius.form.address.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'sylius.form.address.last_name',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'sylius.form.address.phone_number',
            ])
            ->add('countryCode', CountryCodeChoiceType::class, [
            ])
            ->add('street', TextType::class, [
                'label' => 'sylius.ui.address',
                'attr' => [
                    'placeholder' => 'sylius.ui.address_placeholder',
                    'autocomplete' => 'nope',
                ],
            ])
            ->add('city', TextType::class, [
            ])
            ->add('postcode', TextType::class, [
            ])
            ->add('fiasCode', TextType::class, [
            ])
            ->addEventSubscriber($this->buildAddressFormSubscriber)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'validation_groups' => function (Options $options) {
                    if ($options['shippable']) {
                        return array_merge($this->validationGroups, ['shippable']);
                    }

                    return $this->validationGroups;
                },
                'shippable' => false,
            ])
            ->setAllowedTypes('shippable', 'bool')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_address';
    }
}
