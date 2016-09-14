<?php

namespace Admin\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Router\RouterInterface as Router;
use Zend\Session\SessionManager;

class LoginHandleAction
{
    private $router;
    private $session;

    public function __construct(Router $router, SessionManager $session)
    {
        $this->router  = $router;
        $this->session = $session;
    }

    /**
     * @todo Need to decide and implement DB strategy so for now we will hard code default user.
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
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
            return $response->withStatus(302)->withHeader('Location', $this->router->generateUri('login'));
        }
    }
}
