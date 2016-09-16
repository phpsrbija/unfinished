<?php

namespace Admin\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Template\TemplateRendererInterface as Template;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\SessionManager;

class AuthController extends AbstractController
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

    // If user is already logged in do a redirect
    public function login()
    {
        if($this->session->getStorage()->user){
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        return new HtmlResponse($this->template->render('admin::login'));
    }

    public function loginHandle()
    {
        if($this->session->getStorage()->user){
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        $data     = $this->request->getParsedBody();
        $email    = isset($data['email']) ? $data['email'] : null;
        $password = isset($data['password']) ? $data['password'] : null;
        $user     = [
            'email'    => 'admin@unfinished.com',
            'password' => 'admin'
        ];

        if($user['email'] === $email && $user['password'] === $password){
            $this->session->getStorage()->user = $user;

            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }
        else{
            return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }
    }

    public function logout()
    {
        $this->session->getStorage()->clear('user');

        return $this->response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
    }

}