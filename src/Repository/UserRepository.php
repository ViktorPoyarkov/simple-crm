<?php

namespace App\Repository;

use App\Entity\Interfaces\Agent;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllUsersByAgent(Agent $agent): array
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.agent', 'a1') // Прямая связь User -> Agent
            ->leftJoin('a1.agent', 'a2') // Косвенная связь через Parent Agent
            ->where('a1.id = :agentId OR a2.id = :agentId')
            ->setParameter('agentId', $agent->getId())
            ->getQuery()
            ->getResult();
    }

    public function findUserByAgent(int $id, Agent $agent): User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.agent', 'a1') // Прямая связь User -> Agent
            ->leftJoin('a1.agent', 'a2') // Косвенная связь через Parent Agent
            ->where('a1.id = :agentId OR a2.id = :agentId')
            ->andWhere('u.id = :userId')
            ->setParameter('agentId', $agent->getId())
            ->setParameter('userId', $id)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
