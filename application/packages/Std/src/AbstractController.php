<?php

declare(strict_types=1);

namespace Std;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class AbstractController.
 * Intended to be extended by any newly created controller.
 */
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
     * Executed whenever controller is instantiated.
     * Determines which action to invoke based on request.
     *
     * @param Request       $request  request
     * @param Response      $response response
     * @param callable|null $next     next middleware
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $action = $request->getAttribute('action', 'index');

        if (!method_exists($this, $action)) {
            // clone new response with 404 status code set
            $response = $response->withStatus(404);

            return $next($request, $response, new \Exception("Function '$action' is not defined!", 404));
        }

        $this->request = $request;
        $this->response = $response;
        $this->next = $next;

        return $this->$action();
    }
}
