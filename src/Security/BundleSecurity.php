<?php

namespace App\Security;

use App\Security\Interfaces\BundleSecurityInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class BundleSecurity implements BundleSecurityInterface
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function getUser(): ?UserInterface
    {
        return $this->security->getUser();
    }

    public function isGranted(mixed $attribute, mixed $subject = null): bool
    {
        return $this->security->isGranted($attribute, $subject);
    }
}