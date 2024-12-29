<?php

namespace App\Services;

use App\Entity\Interfaces\Agent;
use App\Entity\Interfaces\User;
use App\Repository\UserRepository;

class UserRepositoryService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function getUsersByAgent(Agent $agent): array
    {
        return $this->userRepository->findAllUsersByAgent($agent);
    }

    public function getUserByAgent(int $id, Agent $agent): User
    {
        return $this->userRepository->findUserByAgent($id, $agent);
    }

    public function getUserWithoutRole(int $id): User
    {
        return $this->userRepository->findOneBy(['id' => $id]);
    }

}