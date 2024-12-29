<?php

namespace App\Services;

use App\Entity\Interfaces\User;
use App\Services\Interfaces\AgentAuthorizationServiceInterface;
use App\Services\Interfaces\UserAuthorizationServiceInterface;
use App\Services\Interfaces\UserService as IUserService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService extends UserRepositoryService implements IUserService
{
    private EntityManagerInterface $entityManager;
    private UserAuthorizationServiceInterface $userAuthorizationService;
    private AgentAuthorizationServiceInterface $agentAuthorizationService;
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserAuthorizationServiceInterface $userAuthorizationService,
        AgentAuthorizationServiceInterface $agentAuthorizationService
    )
    {
        parent::__construct($userRepository);
        $this->entityManager = $entityManager;
        $this->userAuthorizationService = $userAuthorizationService;
        $this->agentAuthorizationService = $agentAuthorizationService;
    }

    public function getUser(int $id): User
    {
        return $this->userAuthorizationService->getUser($id);
    }

    public function getUsers(): array
    {
        return $this->userAuthorizationService->getUsers();
    }

    public function assignUser(int $userId, int $agentId): void
    {
        $agent = $this->agentAuthorizationService->getAgent($agentId);
        $user = $this->userAuthorizationService->getUser($userId);
        $user->setAgent($agent);
        $this->entityManager->persist($agent);
        $this->entityManager->flush();

    }

    public function deleteUser(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}