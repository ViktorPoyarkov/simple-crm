<?php

namespace App\Entity;

use App\Repository\AssetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssetRepository::class)]
class Asset
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    private ?string $pair = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 5)]
    private ?string $bid = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 5)]
    private ?string $ask = null;

    #[ORM\Column]
    private ?int $lot_size = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_update = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBid(): ?string
    {
        return $this->bid;
    }

    public function setBid(string $bid): static
    {
        $this->bid = $bid;

        return $this;
    }

    public function getAsk(): ?string
    {
        return $this->ask;
    }

    public function setAsk(string $ask): static
    {
        $this->ask = $ask;

        return $this;
    }

    public function getLotSize(): ?int
    {
        return $this->lot_size;
    }

    public function setLot(int $lot_size): static
    {
        $this->lot_size = $lot_size;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(\DateTimeInterface $date_update): static
    {
        $this->date_update = $date_update;

        return $this;
    }
}
