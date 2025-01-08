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

    public function updateOpenPnl(float $ask): void
    {
        $this->createQueryBuilder('t')
            ->update('t')
            ->join('t.user', 'u')
            ->join('u.currency', 'c')
            ->set('t.pnl',
                "CASE 
                WHEN t.position = 1 THEN 
                    (($ask - t.entry_rate) * (t.trade_size * t.lot_count * 0.01 * c.rate_to_usd) * 100)
                WHEN t.position = 0 THEN 
                    ((t.entry_rate - $ask) * (t.trade_size * t.lot_count * 0.01 * c.rate_to_usd) * 100)
            END"
            )
            ->where('t.status = :status')
            ->setParameter('status', 1);
    }

    public function updateUsedMargin(float $bid): void
    {
        $this->createQueryBuilder('t')
            ->update('t')
            ->join('t.user', 'u')
            ->join('u.currency', 'c')
            ->set('t.used_margin', 't.trade_size * 0.1 * c.rate_to_usd * :bidPrice')
            ->where('t.status = :status')
            ->setParameter('bidPrice', $bid)
            ->setParameter('status', 1);
    }
}
