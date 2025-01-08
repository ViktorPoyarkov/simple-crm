<?php

namespace App\Services;
use App\Entity\Interfaces\Trade;
use App\Entity\Interfaces\User;
use App\Entity\Interfaces\Agent;
use App\Repository\TradeRepository;
use App\Services\Interfaces\TradeAuthorizationServiceInterface;
use App\Services\Interfaces\TradeService as ITradeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;

class TradeService implements ITradeService
{
    protected TradeRepository $tradeRepository;
    protected TradeAuthorizationServiceInterface $tradeAuthorizationService;
    protected HandleTradeService $handleTradeService;
    private EntityManagerInterface $entityManager;
    public function __construct(
        TradeRepository $tradeRepository,
        TradeAuthorizationServiceInterface $tradeAuthorizationService,
        HandleTradeService $handleTradeService,
        EntityManagerInterface $entityManager
    )
    {
        $this->tradeRepository = $tradeRepository;
        $this->tradeAuthorizationService = $tradeAuthorizationService;
        $this->handleTradeService = $handleTradeService;
        $this->entityManager = $entityManager;
    }

    public function getTrade(int $id): Trade
    {
        return $this->tradeAuthorizationService->getTrade($id);
    }

    public function getTrades(): array
    {
        return $this->tradeAuthorizationService->getTrades();
    }

    public function getTradeForUser(int $id, User $user): Trade
    {
        return $this->tradeRepository->findOneBy([
            'id' => $id,
            'user' => $user
        ]);
    }

    public function getTradeForAgent(int $id, Agent $agent): Trade
    {
        return $this->tradeRepository->getTradeByAgent($agent);
    }

    public function getTradeWithoutRole(int $id): Trade
    {
        return $this->tradeRepository->findOneBy(['id' => $id]);
    }

    public function getTradesForUser(User $user): array
    {
        return $this->tradeRepository->findBy(['user' => $user]);
    }

    public function getTradesForAgent(Agent $agent): array
    {
        return $this->tradeRepository->getTradesByAgent($agent);
    }

    public function getTradesWithoutRole(): array
    {
        return $this->tradeRepository->findAll();
    }

    public function openTrade(InputBag $input): int
    {
        return $this->handleTradeService->openTrade($input);
    }

    public function closeTrade(int $id): void
    {
        $this->handleTradeService->closeTrade($id);
    }

    public function updateOpenPnl(float $ask)
    {
        $this->tradeRepository->updateOpenPnl($ask);
    }

    public function updateUsedMargin(float $bid): void
    {
        $this->tradeRepository->updateUsedMargin($bid);
    }

    public function stopOut(): void
    {
        $this->entityManager->getConnection()->executeStatement('CALL StopOutProcess()');
    }
}