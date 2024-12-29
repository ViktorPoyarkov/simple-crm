<?php

namespace App\Entity\Interfaces;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface User extends UserInterface, PasswordAuthenticatedUserInterface
{
    public function isUser(): bool;
}