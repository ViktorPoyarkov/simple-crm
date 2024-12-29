<?php

namespace App\Services;

use App\Entity\Agent;
use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class LogService
{
    private Security $security;
    private EntityManagerInterface $entityManager;
    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function createLog(string $action): void
    {
        $log = new Log();
        $user = $this->security->getUser();
        if ($user instanceof Agent) {
            $log->setAgent($user);
        } else {
            $log->setUser($user);
        }
        $log->setActionName($action);
        $log->setDateCreated(new \DateTimeImmutable());
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

}