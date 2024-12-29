<?php

namespace App\Controller;

use App\Services\Interfaces\AgentService;
use App\Services\Interfaces\UserService;
use App\Services\LogService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users')]
final class UserController extends AbstractEventController
{
    private UserService $userService;
    private AgentService $agentService;
    public function __construct(UserService $userService, AgentService $agentService, LogService $logService)
    {
        parent::__construct($logService);
        $this->userService = $userService;
        $this->agentService = $agentService;
    }

    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $this->userService->getUsers(),
        ]);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $this->userService->getUser($id),
        ]);
    }

    #[Route('/assign/{id}', name: 'app_user_assign_page', methods: ['GET'])]
    public function assignUserToAgentPage(int $id)
    {
        return $this->render('user/assign.html.twig', [
            'user' => $this->userService->getUser($id),
            'agents' => $this->agentService->getAgents()
        ]);
    }

    #[Route('/assign-post', name: 'app_user_assign', methods: ['POST'])]
    public function assignUserToAgent(
        Request $request,
        EntityManagerInterface $entityManager
    ): RedirectResponse
    {
        $user = $this->userService->getUser($request->request->get('userId'));
        $agent = $this->agentService->getAgent($request->request->get('agentId'));
        $user->setAgent($agent);
        $entityManager->persist($user);
        $entityManager->flush();
        $referer = $request->headers->get('referer');
        $this->logger->log('assign_user');
        if ($referer) {
            return $this->redirect($referer);
        }

        return $this->redirect('/');
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($this->userService->getUser($id));
        $entityManager->flush();

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
