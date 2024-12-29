<?php

namespace App\Services\Interfaces;

interface TradeRoleStrategyResolverInterface extends RoleStrategyResolverInterface
{
    public function resolve(): TradeRoleStrategyInterface;
}