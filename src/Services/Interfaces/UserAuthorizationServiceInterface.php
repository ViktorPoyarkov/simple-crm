<?php

namespace App\Services\Interfaces;
use App\Entity\Interfaces\User;

interface UserAuthorizationServiceInterface
{
    public function getUsers(): array;
    public function getUser(int $id): User;
}