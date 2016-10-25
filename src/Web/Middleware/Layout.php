<?php
declare(strict_types = 1);
namespace Web\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class Layout.
 *
 * @package Web\Middleware
 */
class Layout
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var mixed
     */
    private $config;

    /**
     * Layout constructor.
     *
     * @param Router $router router
     * @param mixed  $config config
     */
    public function __construct(Router $router, $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * Chenge layout for web and admin.
     *
     * @todo On Ajax requests no render layout at all!
     * @todo Add additional logics - no render on specific routes or URIs or HTTP Headers ...
     * @nice-to-know if we want to change layout based on route name (powerful on grouped routes):
     *      1. Register this Middleware after ROUTING_MIDDLEWARE!
     *      2. $result = $request->getAttribute('Zend\Expressive\Router\RouteResult');
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        if (0 === strpos($request->getUri()->getPath(), '/admin')) {
            $this->config['templates']['layout'] = 'layout/admin';
        }

        return $next($request, $response);
    }
}
