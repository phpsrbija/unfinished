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
        $urlSlug = $request->getAttribute('category');

        $category = $this->categoryService->getCategoryBySlug($urlSlug);

        if(!$category) {
            $response = $response->withStatus(404);

            return $next($request, $response, new \Exception("Category by URL does not exist!", 404));
        }

        $posts = $this->categoryService->getCategoryPostsPagination($category, 1);

        return new HtmlResponse($this->template->render('web::category', [
            'layout'   => 'layout/web',
            'category' => $category,
            'posts'    => $posts
        ]));
    }

}
