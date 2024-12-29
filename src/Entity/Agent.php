<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Interfaces\Agent as IAgent;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent implements IAgent
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

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'agent_id', referencedColumnName: 'id')]
    private Agent|null $agent = null;

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

    public function eraseCredentials()
    {
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    public function isAgent(): bool
    {
        return true;
    }
}
