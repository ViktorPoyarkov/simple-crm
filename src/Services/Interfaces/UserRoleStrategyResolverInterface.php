<?php

namespace App\Services\Interfaces;

interface UserRoleStrategyResolverInterface extends RoleStrategyResolverInterface
{
    public function resolve(): UserRoleStrategyInterface;
}