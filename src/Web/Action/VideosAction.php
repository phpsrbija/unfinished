<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\VideoService;
use Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class VideosAction.
 *
 * @package Web\Action
 */
class VideosAction
{
    /** @var Template */
    private $template;

    /** @var VideoService */
    private $videoService;

    /** @var CategoryService */
    private $categoryService;

    /**
     * VideosAction constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template, VideoService $videoService, CategoryService $categoryService)
    {
        $this->template        = $template;
        $this->videoService    = $videoService;
        $this->categoryService = $categoryService;
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
        $params = $request->getQueryParams();
        $page   = isset($params['page']) ? $params['page'] : 1;
        $videos = $this->videoService->fetchWebArticles($page, 5);

        return new HtmlResponse($this->template->render('web::videos', [
            'layout' => 'layout/web',
            'videos' => $videos
        ]));
    }

}
