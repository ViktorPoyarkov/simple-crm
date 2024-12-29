<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    private UserPasswordHasherInterface $passwordHasher;
    private CurrencyRepository $currencyRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        CurrencyRepository $currencyRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->currencyRepository = $currencyRepository;
        $this->entityManager = $entityManager;
    }

    public function registerUser(InputBag $inputBag): User
    {
        $username = $inputBag->get('username');
        $password = $inputBag->get('password');
        $currency = $this->currencyRepository->findOneBy(['code' => $inputBag->get('currency')]);
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);
        $user->setUsername($username);
        $user->setCurrency($currency);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}