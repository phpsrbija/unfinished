<?php
namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class IndexAction.
 *
 * @package Admin\Action
 */
final class IndexAction
{
    /**
     * @var Template
     */
    private $template;

    /**
     * IndexAction constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Executed when action is called.
     *
     * @param Request       $request  request
     * @param Response      $response response
     * @param callable|null $next     next middleware
     *
     * @return HtmlResponse
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        return new HtmlResponse($this->template->render('admin::index', ['layout' => 'layout/admin']));
    }
}
