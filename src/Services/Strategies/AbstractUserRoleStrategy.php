<?php

namespace App\Services\Strategies;
use App\Services\Interfaces\UserRoleStrategyInterface;
use App\Services\Interfaces\UserService;

abstract class AbstractUserRoleStrategy extends AbstractRoleStrategy implements UserRoleStrategyInterface
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
}