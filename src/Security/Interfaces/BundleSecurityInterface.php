<?php

namespace App\Security\Interfaces;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface BundleSecurityInterface extends AuthorizationCheckerInterface
{
    public function getUser(): ?UserInterface;
}