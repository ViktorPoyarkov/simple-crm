<?php

namespace App\Services\Strategies;

use App\Entity\Interfaces\User;

class UserAdminRoleStrategy extends AbstractUserRoleStrategy
{
    private const ROLE_ADMIN = 'ROLE_ADMIN';

    public function getUsers(): array
    {
        return $this->userService->getAllUsers();
    }

    public function getUser(int $id): User
    {
        return $this->userService->getUserWithoutRole($id);
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_ADMIN;
    }

}