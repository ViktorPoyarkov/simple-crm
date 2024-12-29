<?php

namespace App\Controller;

use App\Entity\Interfaces\Agent;
use App\Services\Interfaces\UserService;
use App\Services\TradeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TraderController extends AbstractController
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/trader', name: 'app_trader', methods: ['GET'])]
    public function getTraderPage(): Response
    {
        $users = [];
        if ($this->getUser() instanceof Agent) {
            $users = $this->userService->getUsers();
        }
        return $this->render('trader/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/trader/add-trade', name: 'app_open_trade', methods: ['POST'])]
    public function openTrade(Request $request, TradeService $tradeService): RedirectResponse
    {
        $newTradeId = $tradeService->openTrade($request->request);

        return $this->redirectToRoute("app_trade_page", ['id' => $newTradeId]);
    }
    #[Route('/trader/close-trade', name: 'app_close_trade', methods: ['POST'])]
    public function closeTrade(Request $request, TradeService $tradeService): RedirectResponse
    {
        $id = $request->request->get('trade_id');
        $tradeService->closeTrade($id);

        return $this->redirectToRoute("app_trader");
    }

    #[Route('/trader/{id}', name: 'app_trade_page', methods: ['GET'])]
    public function getTradePage(int $id, TradeService $tradeService): Response
    {
        $trade = $tradeService->getTrade($id);
        if ($trade->getStatus() !== $trade::OPEN_STATUS) {
            return $this->redirectToRoute('app_trader');
        }
        return $this->render('trader/trade.html.twig', [
            'trade' => $trade
        ]);
    }

}