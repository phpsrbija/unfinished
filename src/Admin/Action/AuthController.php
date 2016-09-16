<?php

namespace Admin\Action;

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

    public function login(Request $request, Response $response)
    {
        // If user is already logged in
        if($this->session->getStorage()->user){
            return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        return new HtmlResponse($this->template->render('admin::login'));
    }

    public function loginHandle(Request $request, Response $response)
    {
        if($this->session->getStorage()->user){
            return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }

        $data     = $request->getParsedBody();
        $email    = isset($data['email']) ? $data['email'] : null;
        $password = isset($data['password']) ? $data['password'] : null;
        $user     = [
            'email'    => 'admin@unfinished.com',
            'password' => 'admin'
        ];

        if($user['email'] === $email && $user['password'] === $password){
            $this->session->getStorage()->user = $user;

            return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }
        else{
            return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
        }
    }

    public function logout(Request $request, Response $response)
    {
        $this->session->getStorage()->clear('user');

        return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('admin'));
    }

}