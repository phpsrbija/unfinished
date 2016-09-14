<?php

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

class LoginAction
{
    private $router;
    private $template;
    private $session;

    public function __construct(Router $router, Template $template, SessionManager $session)
    {
        $this->router   = $router;
        $this->template = $template;
        $this->session  = $session;
    }

    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        // If user is already logged in
        if($this->session->getStorage()->user){
            return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        return new HtmlResponse($this->template->render('admin::login'));
    }
}
