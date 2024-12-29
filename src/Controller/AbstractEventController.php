<?php

namespace App\Controller;

use App\Logging\Logger;
use App\Services\LogService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractEventController extends AbstractController
{
    protected Logger $logger;
    public function __construct(LogService $logService)
    {
        $this->logger = new Logger($logService);
    }
}