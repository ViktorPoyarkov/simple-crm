<?php

namespace App\Entity\Interfaces;

interface Trade
{
    public const BUY = 1;
    public const SELL = 0;
    public const OPEN_STATUS = 0;
    public const WON_STATUS = 1;
    public const LOSE_STATUS = 2;
    public const TIE_STATUS = 3;
    public function isTrade(): bool;
}