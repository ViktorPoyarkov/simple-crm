<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Interfaces\User as IUser;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements IUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $login_time = null;

    #[ORM\ManyToOne(targetEntity: Currency::class)]
    #[ORM\JoinColumn(name: 'currency_id', referencedColumnName: 'id')]
    private Currency|null $currency = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $total_pnl = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $equity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $cash_balance = null;


    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'users')]
    #[ORM\JoinColumn(name: 'agent_id', referencedColumnName: 'id')]
    private ?User $agent = null;

    #[ORM\OneToMany(mappedBy: 'agent', targetEntity: self::class)]
    private Collection $users;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getLoginTime(): ?\DateTimeInterface
    {
        return $this->login_time;
    }

    public function setLoginTime(?\DateTimeInterface $login_time): static
    {
        $this->login_time = $login_time;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTotalPnl(): ?string
    {
        return $this->total_pnl;
    }

    public function setTotalPnl(string $total_pnl): static
    {
        $this->total_pnl = $total_pnl;

        return $this;
    }

    public function getEquity(): ?string
    {
        return $this->equity;
    }

    public function setEquity(?string $equity): static
    {
        $this->equity = $equity;

        return $this;
    }

    public function getCashBalance(): ?string
    {
        return $this->cash_balance;
    }

    public function setCashBalance(?string $cash_balance): static
    {
        $this->cash_balance = $cash_balance;

        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    public function isUser(): bool
    {
        return true;
    }
}
