<?php

declare(strict_types=1);

namespace Admin\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Session\SessionManager;

/**
 * Class AdminAuth.
 */
final class AdminAuth
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var SessionManager
     */
    private $session;

    /**
     * AdminAuth constructor.
     *
     * @param Router         $router  router
     * @param SessionManager $session session manager
     */
    public function __construct(Router $router, SessionManager $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * Called when middleware is invoked.
     *
     * @param Request       $request  request
     * @param Response      $response response
     * @param callable|null $next     next callable in line
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        /**
         * Check if user is logged in.
         */
        $user = $this->session->getStorage()->user;
        if (!$user) {
            return $response->withStatus(302)->withHeader(
                'Location',
                $this->router->generateUri('auth', ['action' => 'login'])
            );
        }

        /*
         * If everything is OK, continue execution middleware
         */
        return $next($request, $response);
    }
}
