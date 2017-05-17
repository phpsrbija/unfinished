<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\PostService;
use Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class CategoryAction.
 *
 * @package Web\Action
 */
class CategoryAction
{
    /** @var Template */
    private $template;

    /** @var PostService */
    private $postService;

    /** @var CategoryService */
    private $categoryService;

    /**
     * CategoryAction constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template, PostService $postService, CategoryService $categoryService)
    {
        $this->template        = $template;
        $this->postService     = $postService;
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
        $params     = $request->getQueryParams();
        $page       = isset($params['page']) ? $params['page'] : 1;
        $urlSlug    = $request->getAttribute('category');
        $categories = $this->categoryService->allWeb();
        $category   = $this->categoryService->getCategoryBySlug($urlSlug);

        if(!$category) {
            $category = (object)[
                'name' => 'SveeEeEEeeEe',
                'slug' => 'all'
            ];
        }

        $posts = $this->categoryService->getCategoryPostsPagination($category, $page);

        return new HtmlResponse($this->template->render('web::category', [
            'layout'          => 'layout/web',
            'categories'      => $categories,
            'currentCategory' => $category,
            'posts'           => $posts
        ]));
    }

}
