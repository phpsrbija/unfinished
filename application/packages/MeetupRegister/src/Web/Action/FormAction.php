<?php

declare(strict_types=1);

namespace MeetupRegister\Web\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

class FormAction
{
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $success = isset($request->getQueryParams()['success']);

        return new HtmlResponse($this->template->render('meetupregister::form', [
            'layout'    => 'layout/web',
            'success'   => $success
        ]));
    }
}
