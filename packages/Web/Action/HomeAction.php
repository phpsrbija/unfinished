<?php

declare(strict_types=1);

namespace Web\Action;

use Page\Service\PageService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class HomeAction.
 *
 * @package Web\Action
 */
class HomeAction
{
    /** @var Template */
    private $template;

    /** @var PageService */
    private $pageService;

    /**
     * HomeAction constructor.
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
     * Get homepage to display body or
     * need to get homepage from Pages package at least for SEO tags
     *
     * @param  Request       $request
     * @param  Response      $response
     * @param  callable|null $next
     *
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ): HtmlResponse {

        $page = $this->pageService->getHomepage();

        return new HtmlResponse($this->template->render('web::home',
            ['page' => $page, 'layout' => 'layout/web']));
    }

}
