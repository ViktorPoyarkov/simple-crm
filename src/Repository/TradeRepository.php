<?php

namespace App\Repository;

use App\Entity\Trade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Agent;

/**
 * @extends ServiceEntityRepository<Trade>
 */
class TradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trade::class);
    }

    public function getTradeByAgent(int $id, Agent $agent): ?Trade
    {
        $trade = $this->findOneBy(['id' => $id]);
        $agentOfTrade = $trade->getUser()->getAgent();
        if ($agent->getId() === $agentOfTrade->getId()) {
            return $trade;
        }

        return null;
    }

    public function getTradesByAgent(Agent $agent): ?array
    {
        return $this->createQueryBuilder('t')
            ->join('t.user', 'u') // Соединяем Trade с User
            ->join('u.agent', 'a') // Соединяем User с Agent
            ->where('a = :agent') // Фильтруем по Agent
            ->setParameter('agent', $agent)
            ->getQuery()
            ->getResult();
    }
}
