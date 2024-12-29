<?php

namespace App\Services\Strategies;

use App\Services\Interfaces\RoleStrategyInterface;
use App\Services\Strategies\Resolvers\Traits\CanStoreAgent;

abstract class AbstractRoleStrategy implements RoleStrategyInterface
{
    use CanStoreAgent;
}