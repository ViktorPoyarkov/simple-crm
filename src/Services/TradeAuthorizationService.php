<?php

namespace App\Services;

use App\Entity\Interfaces\Trade;

class TradeAuthorizationService extends BaseAuthorizationService implements Interfaces\TradeAuthorizationServiceInterface
{

    public function getTrades(): array
    {
        return (new parent($this->security, $this->roleStrategyResolver))->getTrades();
    }

    public function getTrade(int $id): Trade
    {
        return (new parent($this->security, $this->roleStrategyResolver))->getTrade($id);
    }
}