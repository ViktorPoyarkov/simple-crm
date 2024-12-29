<?php

namespace App\Services\Strategies;

use App\Services\Interfaces\AgentRoleStrategyInterface;
use App\Services\Interfaces\AgentService;

abstract class AbstractAgentRoleStrategy extends AbstractRoleStrategy implements AgentRoleStrategyInterface
{
    protected AgentService $agentService;

    public function __construct(AgentService $agentService)
    {
        $this->agentService = $agentService;
    }
}