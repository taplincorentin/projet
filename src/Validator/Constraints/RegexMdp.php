<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class RegexMdp extends Constraint
{
    public $message = 'Le mot de passe doit avoir au moins 8 caractères dont une majuscule et un caractère spécial';
}