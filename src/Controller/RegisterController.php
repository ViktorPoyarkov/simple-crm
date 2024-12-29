<?php

namespace App\Controller;

use App\Services\LogService;
use App\Services\RegisterService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractEventController
{
    private RegisterService $registerService;
    private Security $security;
    public function __construct(RegisterService $registerService, Security $security, LogService $logService)
    {
        parent::__construct($logService);
        $this->registerService = $registerService;
        $this->security = $security;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function getRegisterPage(Request $request): Response
    {
        if ($request->getMethod() == 'POST') {
            $user = $this->registerService->registerUser($request->request);
            $this->security->login($user);
            $this->logger->log('register');
            return $this->redirectToRoute('app_trader');
        }
        return $this->render('register/register.html.twig', [
        ]);
    }
}
