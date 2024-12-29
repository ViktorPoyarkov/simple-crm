<?php
namespace App\Entity\Interfaces;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface Agent extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function isAgent(): bool;
}