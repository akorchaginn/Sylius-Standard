<?php


namespace Override\CoreBundle\Validator\Constraints;


use IntegrationBundle\Utils\GoogleRecaptchaClient;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RecaptchaConstraintValidator extends ConstraintValidator
{
    /** @var GoogleRecaptchaClient $googleRecaptchaClient */
    private $googleRecaptchaClient;

    /**
     * RecaptchaConstraintValidator constructor.
     * @param GoogleRecaptchaClient $googleRecaptchaClient
     */
    public function __construct(GoogleRecaptchaClient $googleRecaptchaClient)
    {
        $this->googleRecaptchaClient = $googleRecaptchaClient;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$this->googleRecaptchaClient->verify($value)) {
            $this->context->buildViolation('marinewool.recaptcha_failed')
                ->addViolation();
        }
    }
}
