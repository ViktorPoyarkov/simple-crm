<?php

namespace App\Services\Interfaces;

use App\Entity\Interfaces\Agent;

interface AgentRoleStrategyInterface extends RoleStrategyInterface
{
    public function getAgents(): array;
    public function getAgent(int $id): Agent;
}