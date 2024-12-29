<?php

namespace App\Services\Interfaces;
use App\Entity\Interfaces\Trade;

interface TradeAuthorizationServiceInterface extends AuthorizationServiceInterface
{
    public function getTrades(): array;
    public function getTrade(int $id): Trade;
}