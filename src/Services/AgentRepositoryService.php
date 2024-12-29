<?php

namespace App\Services;

use App\Entity\Interfaces\Agent;
use App\Repository\AgentRepository;

class AgentRepositoryService
{
    protected AgentRepository $agentRepository;
    public function __construct(AgentRepository $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    public function getAgentWithoutRole(int $id): Agent
    {
        return $this->agentRepository->findOneBy(['id' => $id]);
    }

    public function getAgentByAgent(int $id, Agent $agent): Agent
    {
        return $this->agentRepository->findOneBy([
            'id' => $id,
            'agent' => $agent
        ]);
    }

    public function getAgentsByAgent(Agent $agent): array
    {
        return $this->agentRepository->findBy(['agent' => $agent]);
    }

    public function getAllAgents(): array
    {
        return $this->agentRepository->findAll();
    }

}