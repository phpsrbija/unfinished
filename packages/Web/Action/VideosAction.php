<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Entity\ArticleType;
use Article\Service\VideoService;
use Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

/**
 * Class VideosAction.
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
     * @param Template        $template
     * @param VideoService    $videoService
     * @param CategoryService $categoryService
     */
    public function __construct(
        Template $template,
        VideoService $videoService,
        CategoryService $categoryService
    ) {
        $this->template = $template;
        $this->videoService = $videoService;
        $this->categoryService = $categoryService;
    }

    /**
     * Executed when action is invoked.
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @throws \Exception
     *
     * @return HtmlResponse
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $params = $request->getQueryParams();
        $page = isset($params['page']) ? $params['page'] : 1;
        $urlSlug = $request->getAttribute('category');
        $category = $this->categoryService->getCategoryBySlug($urlSlug);

        if (!$category || $category->type != ArticleType::VIDEO) {
            return $next($request, $response);
        }

        return new HtmlResponse($this->template->render('web::videos', [
            'layout'   => 'layout/web',
            'videos'   => $this->videoService->fetchWebArticles($page, 5),
            'category' => $category,
        ]));
    }
}
