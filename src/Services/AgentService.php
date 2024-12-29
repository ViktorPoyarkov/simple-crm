<?php

namespace App\Services;

use App\Repository\AgentRepository;
use App\Entity\Interfaces\Agent;
use App\Services\Interfaces\AgentService as IAgentService;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Interfaces\AgentAuthorizationServiceInterface;

class AgentService extends AgentRepositoryService implements IAgentService
{
    private EntityManagerInterface $entityManager;
    private AgentAuthorizationServiceInterface $authorizationService;
    public function __construct(
        AgentRepository $agentRepository,
        EntityManagerInterface $entityManager,
        AgentAuthorizationServiceInterface $authorizationService
    )
    {
        parent::__construct($agentRepository);
        $this->entityManager = $entityManager;
        $this->authorizationService = $authorizationService;
    }

    public function getAgents(): array
    {
        return $this->authorizationService->getAgents();
    }

    public function getAgent(int $id): Agent
    {
        return $this->authorizationService->getAgent($id);
    }

    public function assignAgent(int $agentForAssignId, int $agentId): void
    {
        $agent = $this->authorizationService->getAgent($agentId);
        $agentForAssign = $this->authorizationService->getAgent($agentForAssignId);
        $agent->setAgent($agentForAssign);
        $this->entityManager->persist($agent);
        $this->entityManager->flush();
    }

    public function deleteAgent(int $id): void
    {
        $this->entityManager->remove($this->authorizationService->getAgent($id));
        $this->entityManager->flush();
    }
}