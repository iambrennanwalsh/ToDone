<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $router;

    public function __construct(RouterInterface $r)
    {
        $this->router = $r;
    }

    public function handle(
        Request $request,
        AccessDeniedException $accessDeniedException
    ) {
        $route = $request->attributes->get('_route');
        if (
            $route === 'Login' ||
            $route === 'Signup' ||
            $route === 'Reset' ||
            $route === 'Forgot'
        ) {
            return new RedirectResponse($this->router->generate('Home'));
        }
    }
}
