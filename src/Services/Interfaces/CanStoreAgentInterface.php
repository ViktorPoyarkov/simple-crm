<?php

namespace App\Services\Interfaces;

use App\Entity\Interfaces\Agent;

interface CanStoreAgentInterface
{
    public function storeAgent(Agent $agent): void;
    public function receiveAgent(): Agent;
}