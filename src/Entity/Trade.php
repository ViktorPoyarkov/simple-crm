<?php

namespace App\Entity;

use App\Repository\TradeRepository;
use Doctrine\DBAL\Types\Types;
use App\Entity\Interfaces\Trade as ITrade;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TradeRepository::class)]
class Trade implements ITrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $trade_size = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $lot_count = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $pnl = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $payout = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $used_margin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 5)]
    private ?string $entry_rate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 5)]
    private ?string $close_rate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_close = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 5, nullable: true)]
    private ?string $stop_loss = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 5, nullable: true)]
    private ?string $take_profit = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]

    private User|null $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    #[ORM\ManyToOne(targetEntity: Asset::class)]
    #[ORM\JoinColumn(name: 'asset_id', referencedColumnName: 'id')]
    private Asset|null $asset = null;

    public function getTradeSize(): ?string
    {
        return $this->trade_size;
    }

    public function setTradeSize(string $trade_size): static
    {
        $this->trade_size = $trade_size;

        return $this;
    }

    public function getLotCount(): ?string
    {
        return $this->lot_count;
    }

    public function setLotCount(string $lot_count): static
    {
        $this->lot_count = $lot_count;

        return $this;
    }

    public function getPnl(): ?string
    {
        return $this->pnl;
    }

    public function setPnl(string $pnl): static
    {
        $this->pnl = $pnl;

        return $this;
    }

    public function getPayout(): ?string
    {
        return $this->payout;
    }

    public function setPayout(?string $payout): static
    {
        $this->payout = $payout;

        return $this;
    }

    public function getUsedMargin(): ?string
    {
        return $this->used_margin;
    }

    public function setUsedMargin(string $used_margin): static
    {
        $this->used_margin = $used_margin;

        return $this;
    }

    public function getEntryRate(): ?string
    {
        return $this->entry_rate;
    }

    public function setEntryRate(string $entry_rate): static
    {
        $this->entry_rate = $entry_rate;

        return $this;
    }

    public function getCloseRate(): ?string
    {
        return $this->close_rate;
    }

    public function setCloseRate(string $close_rate): static
    {
        $this->close_rate = $close_rate;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): static
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateClose(): ?\DateTimeInterface
    {
        return $this->date_close;
    }

    public function setDateClose(?\DateTimeInterface $date_close): static
    {
        $this->date_close = $date_close;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getStopLoss(): ?string
    {
        return $this->stop_loss;
    }

    public function setStopLoss(?string $stop_loss): void
    {
        $this->stop_loss = $stop_loss;
    }

    public function getTakeProfit(): ?string
    {
        return $this->take_profit;
    }

    public function setTakeProfit(?string $take_profit): void
    {
        $this->take_profit = $take_profit;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(Asset $asset): static
    {
        $this->asset = $asset;

        return $this;
    }

    public function isTrade(): bool
    {
        return true;
    }
}
