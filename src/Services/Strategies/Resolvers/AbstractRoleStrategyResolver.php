<?php
namespace App\Services\Strategies\Resolvers;
use App\Services\Interfaces\CanStoreAgentInterface;
use App\Services\Interfaces\RoleStrategyResolverInterface;
use App\Services\Interfaces\RoleStrategyInterface;
use App\Services\Strategies\Resolvers\Traits\CanStoreAgent;

abstract class AbstractRoleStrategyResolver implements RoleStrategyResolverInterface, CanStoreAgentInterface
{
    use CanStoreAgent;
    /** @var RoleStrategyInterface[] */
    protected array $strategies = [];
    /** @param RoleStrategyInterface[] */
    public function __construct(iterable $strategies)
    {
        foreach ($strategies as $strategy) {
            $this->setStrategy($strategy);
        }
    }

    private function setStrategy(RoleStrategyInterface $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    abstract public function resolve(): RoleStrategyInterface;
}