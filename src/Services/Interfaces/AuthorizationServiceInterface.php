<?php

namespace App\Services\Interfaces;

use App\Security\Interfaces\BundleSecurityInterface as Security;

interface AuthorizationServiceInterface
{
    public function __construct(Security $security, RoleStrategyResolverInterface $roleStrategyResolver);
}