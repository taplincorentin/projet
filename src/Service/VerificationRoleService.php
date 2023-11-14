<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class VerificationRoleService
{
    private $verificationAuthorisation;

    public function __construct(AuthorizationCheckerInterface $verificationAuthorisation)
    {
        $this->verificationAuthorisation = $verificationAuthorisation;
    }

    public function verificationAdmin(): bool
    {
        // Check if user has ROLE_ADMIN or ROLE_SUPER_ADMIN
        return $this->verificationAuthorisation->isGranted('ROLE_ADMIN') || $this->verificationAuthorisation->isGranted('ROLE_SUPER_ADMIN');
    }

    public function verificationSuperAdmin(): bool
    {
        // Check if user has ROLE_ADMIN or ROLE_SUPER_ADMIN
        return $this->verificationAuthorisation->isGranted('ROLE_SUPER_ADMIN');
    }
}