<?php

namespace App\Services;

use App\Entity\Interfaces\Agent;
use App\Services\Interfaces\AgentAuthorizationServiceInterface;

class AgentAuthorizationService extends BaseAuthorizationService implements AgentAuthorizationServiceInterface
{
    public function getAgents(): array
    {
        return (new parent($this->security, $this->roleStrategyResolver))->getAgents();
    }

    public function getAgent($id): Agent
    {
        return (new parent($this->security, $this->roleStrategyResolver))->getAgent($id);
    }
}