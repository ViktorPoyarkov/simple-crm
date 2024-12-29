<?php
namespace App\Services\Strategies;
use App\Entity\Interfaces\Agent;

class AdminAgentRoleStrategy extends AbstractAgentRoleStrategy
{
    private const ROLE_ADMIN = 'ROLE_ADMIN';

    public function getAgents(): array
    {
        return $this->agentService->getAllAgents();

    }

    public function getAgent(int $id): Agent
    {
        return $this->agentService->getAgentWithoutRole($id);
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_ADMIN;
    }
}