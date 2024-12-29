<?php

namespace App\Form\FormHandlers;

use App\Form\Interfaces\FormHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler implements FormHandlerInterface
{
    private FormFactoryInterface $formFactory;
    private EntityManagerInterface $entityManager;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    public function handle(Request $request, string $formClass, $entity): ?FormInterface
    {
        $form = $this->formFactory->create($formClass, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            return null;
        }

        return $form;
    }
}