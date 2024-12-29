<?php
namespace App\Command;

use App\Repository\AssetRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use React\EventLoop\Loop;
use Ratchet\Client\Connector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

#[AsCommand(
    name: 'app:run-socket-server',
    description: 'Run socket server',
    hidden: false,
    aliases: ['app:run-socket'])]
class RunSocketCommand extends Command
{
    private AssetRepository $assetRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(AssetRepository $assetRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->assetRepository = $assetRepository;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = "wss://stream.binance.com:9443/ws/btcusdt@bookTicker";

        $loop = Loop::get();
        $connector = new Connector($loop);
        $connector($url)->then(function ($connection) use ($loop, &$bid, &$ask) {
            echo "Connected to WebSocket server!\n";
            $connection->on('message', function ($message) use (&$bid, &$ask) {
                $newBid = json_decode($message, true)['b'];
                $newAsk = json_decode($message, true)['a'];
                $needRefresh = false;
                if ($bid !== $newBid) {
                    $bid = $newBid;
                    $needRefresh = true;
                }
                if ($ask !== $newAsk) {
                    $ask = $newAsk;
                    $needRefresh = true;
                }
                if ($needRefresh) {
                    $asset = $this->assetRepository
                        ->findOneBy(['id' => 1]);
                    $asset->setBid($newBid);
                    $asset->setAsk($newAsk);
                    $asset->setDateUpdate(new \DateTimeImmutable());
                    $this->entityManager->persist($asset);
                    $this->entityManager->flush();
                }
            });

            $connection->on('close', function () {
                echo "Connection closed.\n";
            });

        }, function ($exception) use ($loop) {
            echo "Could not connect: {$exception->getMessage()}\n";
            $loop->stop();
        });
        $loop->run();

        return Command::SUCCESS;
    }
}