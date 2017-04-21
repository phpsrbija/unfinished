<?php
declare(strict_types=1);

namespace Core\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class ErrorNotFound.
 *
 * @package Core\Middleware
 */
final class ErrorNotFound
{
    /**
     * @var Template
     */
    private $template;

    /**
     * ErrorNotFound constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Invoked when middleware is executed.
     *
     * @param  Request $request    request
     * @param  Response $response  response
     * @param  callable|null $next next in line
     * @return HtmlResponse
     */
    public function __invoke(Request $request, Response $response, callable $next = null): HtmlResponse
    {
        return new HtmlResponse($this->template->render('error::404'), 404);
    }
}
