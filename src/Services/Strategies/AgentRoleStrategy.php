<?php

namespace App\Services\Strategies;

use App\Entity\Interfaces\Agent;

class AgentRoleStrategy extends AbstractAgentRoleStrategy
{
    private const ROLE_AGENT = 'ROLE_AGENT';

    public function getAgents(): array
    {
        return $this->agentService->getAgentsByAgent($this->receiveAgent());
    }

    public function getAgent(int $id): Agent
    {
        return $this->agentService->getAgentByAgent($id, $this->receiveAgent());
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_AGENT;
    }

}