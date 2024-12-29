<?php

namespace App\Services\Interfaces;

interface AgentRoleStrategyResolverInterface extends RoleStrategyResolverInterface
{
    public function resolve(): AgentRoleStrategyInterface;
}