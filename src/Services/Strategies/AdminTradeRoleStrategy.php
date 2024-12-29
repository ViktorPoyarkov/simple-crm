<?php

namespace App\Services\Strategies;

use App\Entity\Interfaces\Trade;

class AdminTradeRoleStrategy extends AbstractTradeRoleStrategy
{
    private const ROLE_ADMIN = 'ROLE_ADMIN';

    public function getTrades(): array
    {
        return $this->tradeService->getTradesWithoutRole();
    }

    public function getTrade(int $id): Trade
    {
        return $this->tradeService->getTradeWithoutRole($id);
    }

    public function supports(string $role): bool
    {
        return $role === self::ROLE_ADMIN;
    }
}