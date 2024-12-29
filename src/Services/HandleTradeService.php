<?php

namespace App\Services;

use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\InputBag;
use App\Repository\TradeRepository;

class HandleTradeService
{
    private AssetRepository $assetRepository;
    private Security $security;
    private EntityManagerInterface $entityManager;
    private TradeRepository $tradeRepository;
    private UserAuthorizationService $userAuthorizationService;
    private TradeAuthorizationService $tradeAuthorizationService;

    public function __construct(
        AssetRepository $assetRepository,
        Security $security,
        EntityManagerInterface $entityManager,
        TradeRepository $tradeRepository,
        UserAuthorizationService $userAuthorizationService,
        TradeAuthorizationService $tradeAuthorizationService
    )
    {
        $this->assetRepository = $assetRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->tradeRepository = $tradeRepository;
        $this->userAuthorizationService = $userAuthorizationService;
        $this->tradeAuthorizationService = $tradeAuthorizationService;
    }

    public function openTrade(InputBag $input): int
    {
        $tradeEntityName = $this->tradeRepository->getClassName();
        $asset = $this->assetRepository->findOneBy(['pair' => $input->get('asset')]);
        if ($input->get('from_user_id')) {
            $user = $this->userAuthorizationService->getUser($input->get('from_user_id'));
        } else {
            $user = $this->security->getUser();
        }

        $currencyRate = $user->getCurrency()->getRateToUsd();
        $bid = $asset->getBid();
        $ask = $asset->getAsk();
        $position = $input->get('position');

        (float) $lotSize = $input->get('lotSize');
        (float) $lotCount = $input->get('numberInput');
        (float) $stopLoss = $input->get('stopLoss');
        (float) $takeProfit = $input->get('takeProfit');
        $pipValue = $lotSize * $lotCount * 0.01 * $currencyRate /* курс евро */;
        $tradeSize = $lotSize * $lotCount;
        $trade = new $tradeEntityName();
        $trade->setAsset($asset);
        $trade->setUser($user);
        $trade->setTradeSize($lotSize * $lotCount);
        $trade->setLotCount($lotCount);
        if ($position === 'buy') {
            $trade->setPnl(($ask - $bid) * $pipValue * 100);
            $trade->setEntryRate($ask);
            $trade->setPosition($tradeEntityName::BUY); // buy|sell
        } else {
            $trade->setPnl(($bid - $ask) * $pipValue * 100);
            $trade->setEntryRate($bid);
            $trade->setPosition(0);
        }
        $trade->setDateCreated(new \DateTime());
        $trade->setStatus($tradeEntityName::OPEN_STATUS);// open|close
        $trade->setStopLoss($stopLoss);
        $trade->setTakeProfit($takeProfit);

        $trade->setUsedMargin($tradeSize * 0.1 * $currencyRate  * $bid);
        $this->entityManager->persist($trade);
        $this->entityManager->flush();

        return $trade->getId();
    }

    public function closeTrade(int $id)
    {
        $trade = $this->tradeAuthorizationService->getTrade($id);
        $asset = $trade->getAsset();
        $tradeSize = $trade->getTradeSize();
        $tradeEntityName =$this->tradeRepository->getClassName();
        if ($tradeEntityName::BUY) {
            $closeRate = $asset->getBid();
            $payout = ($closeRate - $trade->getEntryRate())  * $tradeSize;
        } else {
            $closeRate =  $asset->getAsk();
            $payout = ($trade->getEntryRate() - $closeRate) * $tradeSize;
        }
        if ($payout > 0) {
            $trade->setStatus($tradeEntityName::WON_STATUS);
        } elseif ($payout < 0) {
            $trade->setStatus($tradeEntityName::LOSE_STATUS);
        } else {
            $trade->setStatus($tradeEntityName::TIE_STATUS);
        }

        $trade->setDateClose(new \DateTimeImmutable());
        $trade->setCloseRate($closeRate);
        $trade->setPayout($payout);
        $this->entityManager->persist($trade);
        $this->entityManager->flush();
    }
}