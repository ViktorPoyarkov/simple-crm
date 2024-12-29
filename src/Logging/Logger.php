<?php

namespace App\Logging;



use App\Services\LogService;

class Logger
{
    private LogService $logService;
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function log(string $action): void
    {
        $this->logService->createLog($action);
    }
}