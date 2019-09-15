<?php

declare(strict_types=1);

namespace Override\CoreBundle\Form\Type\Checkout;

use Sylius\Bundle\CoreBundle\Form\Type\Checkout\AddressType as SyliusAddressType;
use Override\AddressingBundle\Form\Type\AddressType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class AddressType
 * @package Override\CoreBundle\Form\Type\Checkout
 */
class AddressTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('shippingAddress')
            ->add('shippingAddress', AddressType::class, [
                'shippable' => true,
                'constraints' => [new Valid()],
            ])
            ->remove('billingAddress')
            ->add('billingAddress', AddressType::class, [
                'constraints' => [new Valid()],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return SyliusAddressType::class;
    }


}
