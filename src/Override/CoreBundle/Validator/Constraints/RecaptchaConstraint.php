<?php


namespace Override\CoreBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class RecaptchaConstraint extends Constraint
{
    /**
     * {@inheritdoc }
     */
    public function validatedBy()
    {
        return 'marinewool_recaptcha';
    }
}
