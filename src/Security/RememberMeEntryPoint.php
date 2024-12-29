<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Routing\RouterInterface;

class RememberMeEntryPoint implements AuthenticationEntryPointInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function start(Request $request, ?\Throwable $authException = null): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('app_login'));
    }
}