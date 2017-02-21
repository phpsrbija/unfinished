<?php declare(strict_types = 1);

namespace Web\Legacy;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class AboutAction.
 *
 * @package Web\Action
 */
class AboutAction
{
    /**
     * @var Template
     */
    private $template;

    /**
     * AboutAction constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
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
        $data = [
            'components' => 'zend-*',
            'template'   => 'zend-view',
            'layout' => 'layout::legacy2sidebars',
        ];

        return new HtmlResponse($this->template->render('legacy::about', $data));
    }
}
