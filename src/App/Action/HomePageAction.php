<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

class HomePageAction
{
    private $template;

    public function __construct(Template $template = null)
    {
        $this->template = $template;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $data = [
            'components' => 'zend-*',
            'template'   => 'zend-view',
        ];

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
