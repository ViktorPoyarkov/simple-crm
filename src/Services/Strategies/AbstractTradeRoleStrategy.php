<?php

namespace App\Services\Strategies;

use App\Services\Interfaces\TradeRoleStrategyInterface;
use App\Services\Interfaces\TradeService;

abstract class AbstractTradeRoleStrategy extends AbstractRoleStrategy implements TradeRoleStrategyInterface
{
    protected TradeService $tradeService;

    public function __construct(TradeService $tradeService)
    {
        $this->tradeService = $tradeService;
    }
}