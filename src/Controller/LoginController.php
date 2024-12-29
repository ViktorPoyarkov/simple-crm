<?php

namespace App\Controller;

use App\Repository\AgentRepository;
use App\Repository\UserRepository;
use App\Services\LogService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractEventController
{
    private UserPasswordHasherInterface $passwordHasher;
    private Security $security;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Security $security, LogService $logService)
    {
        parent::__construct($logService);
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }

    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function loginPage(): Response
    {
        return $this->render('login/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/login-post', name: 'app_login_post', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, AgentRepository $agentRepository): RedirectResponse
    {
        $criteria = ['username' => $request->get('username')];
        $password = $request->get('password');
        $user = $userRepository->findOneBy($criteria);
        $isLogin = false;
        if (!is_null($user)) {
            if($this->passwordHasher->isPasswordValid($user, $password)){
                $this->security->login($user);
                $isLogin = true;
            }
        }

        $agent = $agentRepository->findOneBy($criteria);
        if (!is_null($agent)) {
            if ($this->passwordHasher->isPasswordValid($agent, $password)) {
                $this->security->login($agent);
                $isLogin = true;
            }
        }

        if ($isLogin) {
            $this->logger->log('login');
            return $this->redirectToRoute('app_trader');
        }

        return $this->redirectToRoute('app_login');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Security $security): RedirectResponse
    {
        $security->logout();
        return $this->redirectToRoute('app_default');
    }
}
