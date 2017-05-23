<?php

declare(strict_types=1);

namespace TmpFakeIt\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class TmpAction.
 *
 * @package TmpFakeIt\Action
 */
class TmpAction
{
    /** @var Template */
    private $template;

    /**
     * CategoryAction constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Executed when action is invoked
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        return new HtmlResponse($this->template->render('web::tmp', ['layout' => 'layout/web']));
    }
}