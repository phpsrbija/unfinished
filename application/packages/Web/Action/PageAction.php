<?php

declare(strict_types = 1);

namespace Web\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Page\Service\PageService;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class PageAction.
 *
 * @package Web\Action
 */
class PageAction
{
    /** @var Template */
    private $template;

    /** @var PageService $pageService */
    private $pageService;

    /**
     * PageAction constructor.
     *
     * @param Template    $template
     * @param PageService $pageService
     */
    public function __construct(Template $template, PageService $pageService)
    {
        $this->template    = $template;
        $this->pageService = $pageService;
    }

    /**
     * Executed when action is invoked
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $urlSlug = $request->getAttribute('url_slug');
        $page    = $this->pageService->getPageBySlug($urlSlug);

        if (!$page) {
            return $next($request, $response);
        }

        return new HtmlResponse($this->template->render('web::page', [
            'layout' => $page->getHasLayout() ? 'layout/web' : false,
            'page'   => $page
        ]));
    }
}
