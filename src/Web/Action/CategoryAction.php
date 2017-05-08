<?php

declare(strict_types=1);

namespace Web\Action;

use Article\Service\PostService;
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

    /**
     * CategoryAction constructor.
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
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return HtmlResponse
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, callable $next = null): HtmlResponse
    {

        $category = '123';//$this->postService->getHomepage();

        //if(!$article) {
        //    throw new \Exception('You need to set homepage!', 404);
        //}

        return new HtmlResponse($this->template->render('web::home', [
            'article' => $category
        ]));
    }

}
