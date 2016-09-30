<?php

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

class IndexAction
{
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $data = [
            'message'    => 'Welcome',
            'additional' => '*',
        ];

        return new HtmlResponse($this->template->render('admin::index', $data));
    }
}
