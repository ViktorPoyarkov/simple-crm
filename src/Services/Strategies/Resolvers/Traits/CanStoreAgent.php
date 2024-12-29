<?php
namespace App\Services\Strategies\Resolvers\Traits;
use App\Entity\Interfaces\Agent;
trait CanStoreAgent
{
    private Agent $agent;

    public function storeAgent(Agent $agent): void
    {
        $this->agent = $agent;
    }

    public function receiveAgent(): Agent
    {
        if (isset($this->agent)) {
            return $this->agent;
        }

        throw new \Exception("Agent wasn't initialized");
    }
}