<?php

namespace App\Services\Interfaces;
use App\Entity\Interfaces\Agent;
use App\Entity\Interfaces\User;

interface UserService
{
    public function getUsers(): array;
    public function assignUser(int $userId, int $agentId): void;
    public function getAllUsers(): array;
    public function getUsersByAgent(Agent $agent): array;
    public function getUser(int $id): User;
    public function getUserWithoutRole(int $id): User;
    public function getUserByAgent(int $id, Agent $agent): User;
    public function deleteUser(User $user): void;
}