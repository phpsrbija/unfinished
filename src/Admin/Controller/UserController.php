<?php

declare(strict_types = 1);

namespace Admin\Controller;

use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Diactoros\Response\HtmlResponse;

class UserController extends AbstractController
{
    /**
     * @var Template
     */
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function index()
    {
        return new HtmlResponse($this->template->render('admin::user/index'));
    }

}