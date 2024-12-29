<?php

namespace App\Services\Interfaces;
use App\Entity\Interfaces\Trade;
use App\Entity\Interfaces\User;
use App\Entity\Interfaces\Agent;
use Symfony\Component\HttpFoundation\InputBag;

interface TradeService
{
    public function getTrade(int $id): Trade;
    public function getTradeForUser(int $id, User $user): Trade;
    public function getTradeForAgent(int $id, Agent $agent): Trade;
    public function getTradeWithoutRole(int $id): Trade;

    public function getTrades(): array;
    public function getTradesForUser(User $user): array;
    public function getTradesForAgent(Agent $agent): array;
    public function getTradesWithoutRole(): array;

    public function openTrade(InputBag $input): int;
    public function closeTrade(int $id): void;

}