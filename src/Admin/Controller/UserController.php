<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class UserController.
 *
 * @package Admin\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    /**
     * UserController constructor.
     *
     * @param Template $template template engine
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Users list
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index() : \Psr\Http\Message\ResponseInterface
    {
        return new HtmlResponse($this->template->render('admin::user/index'));
    }
}
