<?php

namespace App\Services\Interfaces;
use App\Entity\Interfaces\Agent;

interface AgentService
{
    public function getAgents(): array;
    public function getAllAgents(): array;
    public function getAgentsByAgent(Agent  $agent): array;

    public function getAgent(int $id): Agent;
    public function getAgentWithoutRole(int $id): Agent;
    public function getAgentByAgent(int $id, Agent $agent): Agent;

    public function assignAgent(int $agentForAssignId, int $agentId): void;
    public function deleteAgent(int $id): void;
}