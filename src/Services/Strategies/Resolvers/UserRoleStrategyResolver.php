<?php

namespace App\Services\Strategies\Resolvers;

use App\Services\Interfaces\UserRoleStrategyInterface;
use App\Services\Interfaces\UserRoleStrategyResolverInterface;

class UserRoleStrategyResolver extends AbstractRoleStrategyResolver implements UserRoleStrategyResolverInterface
{

    public function resolve(): UserRoleStrategyInterface
    {
        $agent = $this->receiveAgent();
        foreach ($agent->getRoles() as $role) {
            foreach ($this->strategies as $strategy) {
                if ($strategy->supports($role)) {
                    return $strategy;
                }
            }
        }

        throw new \LogicException('No strategy found for the given roles.');
    }
}