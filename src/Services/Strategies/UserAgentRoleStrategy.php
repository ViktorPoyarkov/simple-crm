<?php

namespace App\Services\Strategies;

use App\Entity\Interfaces\User;

class UserAgentRoleStrategy extends AbstractUserRoleStrategy
{
    private const ROLE_AGENT = 'ROLE_AGENT';

    public function getUsers(): array
    {
        return $this->userService->getUsersByAgent($this->receiveAgent());
    }

    public function getUser(int $id): User
    {
        return $this->userService->getUserByAgent($id, $this->receiveAgent());
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_AGENT;
    }
}