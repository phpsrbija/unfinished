<?php

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

/**
 * Class AbstractPage.
 * Base class for all crud based pages.
 *
 * @package Admin\Action
 */
class AbstractPage
{
    private $template;

    /**
     * AbstractAction constructor method.
     *
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Invocation chain method.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $action = $request->getAttribute('action', 'index') . 'Action';

        if (!method_exists($this, $action)) {
            return $next($request, $response, new \Core\Middleware\ErrorNotFound($this->template));
        }

        return $this->$action($request, $response, $next);
    }

    /**
     * Template getter method.
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Default page, should probably list all items.
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null) {}

    /**
     * Create new entity page.
     */
    public function addAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null) {}

    /**
     * Update an existing entity page.
     */
    public function editAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null) {}
}

