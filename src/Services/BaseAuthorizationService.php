<?php

namespace App\Services;

use App\Services\Interfaces\AuthorizationServiceInterface;
use App\Services\Interfaces\RoleStrategyResolverInterface;
use App\Security\Interfaces\BundleSecurityInterface as Security;

class BaseAuthorizationService implements AuthorizationServiceInterface
{
    protected Security $security;
    protected RoleStrategyResolverInterface $roleStrategyResolver;
    public function __construct(Security $security, RoleStrategyResolverInterface $roleStrategyResolver)
    {
        $this->security = $security;
        $this->roleStrategyResolver = $roleStrategyResolver;
        $this->roleStrategyResolver->storeAgent($this->security->getUser());
    }

    public function __call(string $name, array $arguments)
    {
        $strategy = $this->roleStrategyResolver->resolve($this->security->getUser()->getRoles());

        return $strategy->$name(...$arguments);
    }
}