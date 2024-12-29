<?php

namespace App\Services\Interfaces;

use App\Entity\Interfaces\Agent;

interface AgentAuthorizationServiceInterface extends AuthorizationServiceInterface
{
    public function getAgents(): array;
    public function getAgent(int $id): Agent;
}