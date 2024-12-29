<?php

namespace App\Services\Strategies;

use App\Entity\Interfaces\Trade;

class AgentTradeRoleStrategy extends AbstractTradeRoleStrategy
{
    private const ROLE_AGENT = 'ROLE_AGENT';

    public function getTrades(): array
    {
        return $this->tradeService->getTradesForAgent($this->receiveAgent());
    }

    public function getTrade(int $id): Trade
    {
        return $this->tradeService->getTradeForAgent($id, $this->receiveAgent());
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_AGENT;
    }
}