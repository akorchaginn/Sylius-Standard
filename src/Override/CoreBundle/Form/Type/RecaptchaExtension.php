<?php


namespace Override\CoreBundle\Form\Type;


use Override\CoreBundle\Validator\Constraints\RecaptchaConstraint;
use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerRegistrationType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class RecaptchaExtension extends AbstractTypeExtension
{

    /** @var RecaptchaConstraint $recaptchaValidator */
    private $recaptchaValidator;

    /**
     * RecaptchaExtension constructor.
     * @param RecaptchaConstraint $recaptchaValidator
     */
    public function __construct(RecaptchaConstraint $recaptchaValidator)
    {
        $this->recaptchaValidator = $recaptchaValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('grecaptcharesponse', TextType::class, [
                    'mapped' => false,
                    'validation_groups' => [
                        'Default'
                    ],
                    'constraints' => $this->recaptchaValidator,
                ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType(): string
    {
        return CustomerRegistrationType::class;
    }


}
