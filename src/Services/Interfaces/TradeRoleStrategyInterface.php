<?php

namespace App\Services\Interfaces;
use App\Entity\Interfaces\Trade;

interface TradeRoleStrategyInterface extends RoleStrategyInterface
{
    public function getTrades(): array;
    public function getTrade(int $id): Trade;
}