<?php

namespace Core\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

class AdminAuth
{
    private $router;
    private $session;

    public function __construct(Router $router, SessionManager $session)
    {
        $this->router  = $router;
        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        /**
         * Check if user is logged in
         */
        $user = $this->session->getStorage()->user;
        if (!$user) {
            return $response->withStatus(302)->withHeader(
                'Location',
                $this->router->generateUri('auth', ['action' => 'login'])
            );
        }

        /**
         * If everything is OK, continue execution middleware
         */
        return $next($request, $response);
    }
}
