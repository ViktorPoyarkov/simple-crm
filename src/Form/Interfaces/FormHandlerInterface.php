<?php

namespace App\Form\Interfaces;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface FormHandlerInterface
{
    public function handle(Request $request, string $formClass, $entity): ?FormInterface;
}