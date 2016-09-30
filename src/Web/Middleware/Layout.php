<?php

namespace Web\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;

class Layout
{
    private $router;
    private $config;

    public function __construct(Router $router, $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * Chenge layout for web and admin. On Ajax requests no render layout!
     *
     * @todo Add additional logics - no render on specific routes or URIs or HTTP Headers ...
     * @nice-to-know if we want to change layout based on route name (powerful on grouped routes):
     *      1. Register this Middleware after ROUTING_MIDDLEWARE!
     *      2. $result = $request->getAttribute('Zend\Expressive\Router\RouteResult');
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        // set empty layout that simulate layout-no-render
        if($request->hasHeader('X-Requested-With') && $request->hasHeader('X-PJAX')){
            $this->config['templates']['layout'] = 'layout/no';
        }

        if(0 === strpos($request->getUri()->getPath(), '/admin')){
            $this->config['templates']['layout'] = 'layout/admin';
        }

        return $next($request, $response);
    }

}