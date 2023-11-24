<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RegexMdpValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{12,}$/', $value)) { #*[A-Z] indique qu'il faut au moins une majuscule
            $this->context->buildViolation($constraint->message)                            #*[!@#$%^&*] indique qu'il faut au moins un caractère spécial
                ->addViolation();                                                           # [A-Za-z\d!@#$%^&*] indique ce que l'on peut utiliser 
                                                                                            #: lettre (maj/min) et caractères spéciaux
        }                                                                                   # {12,} indique une longueur minimale de 12 caractères
    }
}