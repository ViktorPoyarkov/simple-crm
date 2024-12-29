<?php

namespace App\Services\Strategies;

use App\Entity\Interfaces\Trade;

class UserTradeRoleStrategy extends AbstractTradeRoleStrategy
{
    private const ROLE_USER = 'ROLE_USER';

    public function getTrades(): array
    {
        return $this->tradeService->getTradesForUser($this->receiveAgent());
    }

    public function getTrade(int $id): Trade
    {
        return $this->tradeService->getTradeForUser($id);
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_USER;
    }
}