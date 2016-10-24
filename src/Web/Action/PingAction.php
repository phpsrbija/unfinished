<?php
declare(strict_types = 1);
namespace Web\Action;

use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class PingAction.
 *
 * @package Web\Action
 */
class PingAction
{
    /**
     * Executed when action is invoked.
     *
     * @param ServerRequestInterface $request  request
     * @param ResponseInterface      $response response
     * @param callable|null          $next     next in line
     *
     * @return JsonResponse
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : JsonResponse {
        return new JsonResponse(['ack' => time()]);
    }
}
