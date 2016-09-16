<?php

namespace Admin\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $action = $request->getAttribute('action', 'index');

        if(!method_exists($this, $action)){
            $response->withStatus(404);

            return $next($request, $response, new \Exception("Function '$action' in controller is not defined!", 404));
        }

        return $this->$action($request, $response, $next);
    }
}
