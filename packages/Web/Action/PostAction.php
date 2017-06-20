<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class PostAction.
 *
 * @package Web\Action
 */
class PostAction
{
    /**
* 
     *
 * @var Template 
*/
    private $template;

    /**
* 
     *
 * @var PostService 
*/
    private $postService;

    /**
     * PostAction constructor.
     *
     * @param Template $template
     */
    public function __construct(Template $template, PostService $postService)
    {
        $this->template    = $template;
        $this->postService = $postService;
    }

    /**
     * Executed when action is invoked
     *
     * @param  Request       $request
     * @param  Response      $response
     * @param  callable|null $next
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $urlSlug1 = $request->getAttribute('segment_1');
        $urlSlug2 = $request->getAttribute('segment_2');

        if($urlSlug2) {
            $categorySlug = $urlSlug1;
            $postSlug     = $urlSlug2;
        } else {
            $categorySlug = null;
            $postSlug     = $urlSlug1;
        }

        $post = $this->postService->fetchSingleArticleBySlug($postSlug);

        if(!$post) {
            return $next($request, $response);
        }

        list($previousPost, $nextPost) = $this->postService->fetchNearestArticle($post->published_at);

        if(!$post) {
            $response = $response->withStatus(404);

            return $next($request, $response, new \Exception("Post by URL does not exist!", 404));
        }

        return new HtmlResponse(
            $this->template->render(
                'web::post', [
                'layout'   => 'layout/web',
                'post'     => $post,
                'previous' => $previousPost,
                'next'     => $nextPost
                ]
            )
        );
    }

}
