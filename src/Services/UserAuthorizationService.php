<?php

namespace App\Services;

use App\Entity\Interfaces\User;
use App\Services\Interfaces\UserAuthorizationServiceInterface;

class UserAuthorizationService extends BaseAuthorizationService implements UserAuthorizationServiceInterface
{
    public function getUser(int $id): User
    {
        return (new parent($this->security, $this->roleStrategyResolver))->getUser($id);
    }

    public function getUsers(): array
    {
        return (new parent($this->security, $this->roleStrategyResolver))->getUsers();
    }

}