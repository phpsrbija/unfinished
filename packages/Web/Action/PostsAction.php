<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\PostService;
use Category\Service\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Article\Entity\ArticleType;

/**
 * Class CategoryAction.
 *
 * @package Web\Action
 */
class PostsAction
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
     * @param Template        $template
     * @param PostService     $postService
     * @param CategoryService $categoryService
     */
    public function __construct(
        Template $template,
        PostService $postService,
        CategoryService $categoryService
    ) {
        $this->template        = $template;
        $this->postService     = $postService;
        $this->categoryService = $categoryService;
    }

    /**
     * Executed when action is invoked
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
    ) {
        $params     = $request->getQueryParams();
        $page       = isset($params['page']) ? $params['page'] : 1;
        $urlSlug    = $request->getAttribute('category');
        $category   = $this->categoryService->getCategoryBySlug($urlSlug);

        if (!$category) {
            if ($urlSlug !== 'all') {
                return $next($request, $response);
            }

            // Default category for all posts
            $category = (object)[
                'name'        => 'Svi članci',
                'slug'        => 'all',
                'title'       => 'Svi članci',
                'description' => 'Svi članci PHP i ostalih tehnologija.',
                'main_img'    => null,
                'type'        => ArticleType::POST
            ];
        }
        elseif ($category->type != ArticleType::POST) {
            return $next($request, $response);
        }

        $posts      = $this->categoryService->getCategoryPostsPagination($category, $page);
        $categories = $this->categoryService->getCategories(true);

        return new HtmlResponse(
            $this->template->render('web::posts', [
                    'layout'          => 'layout/web',
                    'categories'      => $categories,
                    'currentCategory' => $category,
                    'posts'           => $posts
                ]
            )
        );
    }
}
