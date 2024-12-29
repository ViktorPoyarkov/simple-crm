<?php

namespace App\Services\Strategies\Resolvers;

use App\Services\Interfaces\TradeRoleStrategyInterface;
use App\Services\Interfaces\TradeRoleStrategyResolverInterface;

class TradeRoleStrategyResolver extends AbstractRoleStrategyResolver implements TradeRoleStrategyResolverInterface
{

    public function resolve(): TradeRoleStrategyInterface
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