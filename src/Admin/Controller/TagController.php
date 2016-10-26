<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class TagController.
 *
 * @package Admin\Controller
 */
class TagController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    /**
     * TagController constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Tags list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index() : \Psr\Http\Message\ResponseInterface
    {
        return new HtmlResponse($this->template->render('admin::tag/index'));
    }
}
