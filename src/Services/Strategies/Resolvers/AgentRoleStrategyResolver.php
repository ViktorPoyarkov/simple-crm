<?php

namespace App\Services\Strategies\Resolvers;

use App\Services\Interfaces\AgentRoleStrategyInterface;
use App\Services\Interfaces\AgentRoleStrategyResolverInterface;

class AgentRoleStrategyResolver extends AbstractRoleStrategyResolver
    implements AgentRoleStrategyResolverInterface {

    public function resolve(): AgentRoleStrategyInterface
    {
        $agent = $this->receiveAgent();
        foreach ($agent->getRoles() as $role) {
            foreach ($this->strategies as $strategy) {
                if ($strategy->supports($role)) {
                    $strategy->storeAgent($agent);
                    return $strategy;
                }
            }
        }

        throw new \LogicException('No strategy found for the given roles.');
    }
}