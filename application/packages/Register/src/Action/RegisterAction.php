<?php

declare(strict_types=1);

namespace Register\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

/**
 * Class RegisterAction.
 */
class RegisterAction
{
    /** @var Template */
    private $template;

    /**
     * RegisterAction constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Page to show form for register
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @throws \Exception
     *
     * @return HtmlResponse
     */
    public function __invoke(Request $request, Response $response, callable $next = null): HtmlResponse
    {
        return new HtmlResponse($this->template->render('register::index', [
            'data'   => null,
            'errors' => null,
            'layout' => 'layout/web'
        ]));
    }
}
