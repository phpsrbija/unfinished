<?php

namespace Admin\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var callable
     */
    protected $next;

    /**
     * Middlware method
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $action = $request->getAttribute('action', 'index');

        if(!method_exists($this, $action)){
            $response->withStatus(404);

            return $next($request, $response, new \Exception("Function '$action' is not defined!", 404));
        }

        $this->request  = $request;
        $this->response = $response;
        $this->next     = $next;

        return $this->$action();
    }
}
