<?php

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Session\SessionManager;

class LogoutHandleAction
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
        $this->session->getStorage()->clear('user');

        return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('login'));
    }
}
