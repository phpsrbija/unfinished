<?php declare(strict_types = 1);

namespace Web\Legacy;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;
use Core\Service\Article\PostService;
use UploadHelper\Upload;

/**
 * Class ListAction.
 *
 * @package Web\Action
 */
class ListAction
{
    /**
     * @var Template
     */
    private $template;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @var Upload
     */
    private $upload;

    /**
     * IndexAction constructor.
     *
     * @param Template    $template template engine
     * @param PostService $postService
     * @param Upload      $upload
     */
    public function __construct(Template $template, PostService $postService, Upload $upload)
    {
        $this->template = $template;
        $this->postService = $postService;
        $this->upload = $upload;
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
        $page = $request->getAttribute('page', 1);
        $perPage = 10;
        $articles = $this->postService->fetchAllArticles($page, $perPage);
        $data = [
            'components' => 'zend-*',
            'template'   => 'zend-view',
            'layout' => 'layout::legacy2sidebars',
            'paginator' => $articles,
            'upload' => $this->upload
        ];

        return new HtmlResponse($this->template->render('legacy::list', $data));
    }
}
