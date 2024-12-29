<?php

namespace App\Services\Interfaces;

interface RoleStrategyInterface extends CanStoreAgentInterface
{
    public function supports(string $role): bool;
}