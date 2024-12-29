<?php

namespace App\Services\Interfaces;

interface RoleStrategyResolverInterface
{
    public function resolve(): RoleStrategyInterface;
}