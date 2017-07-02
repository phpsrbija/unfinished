<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Entity\ArticleType;
use Article\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

/**
 * Class PostAction.
 */
class PostAction
{
    /** @var Template */
    private $template;

    /** @var PostService */
    private $postService;

    /**
     * PostAction constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template, PostService $postService)
    {
        $this->template = $template;
        $this->postService = $postService;
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
        $categorySlug = $request->getAttribute('segment_1');
        $postSlug = $request->getAttribute('segment_2');
        $post = $this->postService->fetchSingleArticleBySlug($postSlug);

        if (!$post || $post->type != ArticleType::POST) {
            return $next($request, $response);
        }

        list($previousPost, $nextPost) = $this->postService->fetchNearestArticle($post->published_at);

        return new HtmlResponse($this->template->render('web::post', [
            'layout'   => 'layout/web',
            'post'     => $post,
            'previous' => $previousPost,
            'next'     => $nextPost,
        ]));
    }
}
