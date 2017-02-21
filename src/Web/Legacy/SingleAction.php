<?php declare(strict_types = 1);

namespace Web\Legacy;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Core\Service\Article\PostService;

/**
 * Class SingleAction.
 *
 * @package Web\Action
 */
class SingleAction
{
    /**
     * @var \Zend\Expressive\ZendView\ZendViewRenderer
     */
    private $template;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * IndexAction constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template, PostService $postService)
    {
        $this->template = $template;
        $this->postService = $postService;
    }

    /**
     * Executed when action is invoked.
     *
     * @param  Request       $request  request
     * @param  Response      $response response
     * @param  callable|null $next     next in line
     * @return HtmlResponse
     */
    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        $article = $this->postService->fetchSingleArticleBySlug($request->getAttribute('slug'));

        $data = [
            'components' => 'zend-*',
            'template'   => 'zend-view',
            'layout'     => 'layout::legacy1sidebar',
            'article'    => $article,
            'pageTitle'  => $article->offsetGet('title')
        ];

        return new HtmlResponse($this->template->render('legacy::single', $data));
    }
}
