<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Services\Interfaces\AgentService;
use App\Services\LogService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;

#[Route('/admin/agents')]
final class AgentController extends AbstractEventController
{
    private AgentService $agentService;
    private UserRepository $userRepository;

    public function __construct(AgentService $agentService, LogService $logService, UserRepository $userRepository)
    {
        parent::__construct($logService);
        $this->agentService = $agentService;
        $this->userRepository = $userRepository;
    }

    #[Route(name: 'app_agent_index', methods: ['GET'])]
    public function index(): Response
    {
        $agents = $this->agentService->getAgents();
        return $this->render('agent/index.html.twig', [
            'agents' => $agents
        ]);
    }

    #[Route('/{id}', name: 'app_agent_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->render('agent/show.html.twig', [
            'agent' => $this->agentService->getAgent($id),
        ]);
    }

    #[Route('/{id}', name: 'app_agent_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): Response
    {
        $this->agentService->deleteAgent($id);

        return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/assign/{id}', name: 'app_agent_assign_page', methods: ['GET'])]
    public function assignAgentToAgentPage(int $id)
    {
        $agentForAssign = $this->agentService->getAgent($id);
        $agents = $this->agentService->getAgents();
        return $this->render('agent/assign.html.twig', [
            'agentForAssign' => $agentForAssign,
            'agents' => $agents
        ]);
    }

    #[Route('/assign-post', name: 'app_agent_assign', methods: ['POST'])]
    public function assignAgentToAgent(Request $request): RedirectResponse
    {
        $agentId = $request->request->get('agentId');
        $agentForAssignId = $request->request->get('agentForAssignId');
        $this->agentService->assignAgent($agentId, $agentForAssignId);
        $this->logger->log('assign_agent');
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        }

        return $this->redirect('/');
    }

    #[Route('/agent-recursive/{id}', name: 'app_agent_assign', methods: ['GET'])]
    public function agentRecursive(int $id): Response
    {
        $user = $this->userRepository->find($id);

        $this->printIds($user);

        return new Response();
    }

    private function printIds(User $user, $first = true)
    {
        if(!$first) {
            echo $user->getId() . ' -- ';
        }
        if (in_array('ROLE_AGENT', $user->getRoles())) {
            foreach ($user->getUsers() as $oneUser) {
                $this->printIds($oneUser, false);

            }
        }
    }
}
