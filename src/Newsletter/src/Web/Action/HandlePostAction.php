<?php

namespace Newsletter\Web\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\JsonResponse;
use Newsletter\Service\NewsletterService;

class HandlePostAction
{
    private $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        try {
            $data  = $request->getParsedBody();
            $email = isset($data['email']) ? $data['email'] : null;

            $this->newsletterService->registerNew($email);

            return new JsonResponse(['message' => 'Uspešno ste se prijavili.']);
        }
        catch(\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
