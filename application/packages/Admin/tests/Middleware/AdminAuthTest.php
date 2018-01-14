<?php

declare(strict_types=1);

namespace Admin\Test\Middleware;

class AdminAuthTest extends \PHPUnit_Framework_TestCase
{
    public function testNotLoggedInUserShouldBeRedirectedToLogin()
    {
        $session = new \Zend\Session\SessionManager();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->setMethods(['generateUri'])
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.test/admin/login'));
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        $adminAuthMiddleware = new \Admin\Middleware\AdminAuth($router, $session);
        /** @var \Zend\Diactoros\Response $response */
        $response = $adminAuthMiddleware($request, $response, function ($request, $response) {
        });
        static::assertSame(302, $response->getStatusCode());
        static::assertSame(['http://unfinished.test/admin/login'], $response->getHeader('Location'));
    }

    public function testExecutionShouldContinueFurtherIfUserIsLoggedIn()
    {
        $session = new \Zend\Session\SessionManager();
        $storage = new \Zend\Session\Storage\ArrayStorage([
            'user' => [
                'email'    => 'admin@example.org',
                'password' => 'secret',
            ],
        ]);
        $session->setStorage($storage);
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $response = new \Zend\Diactoros\Response();
        $adminAuthMiddleware = new \Admin\Middleware\AdminAuth($router, $session);
        $middlewareResponse = $adminAuthMiddleware($request, $response, function ($request, $response) {
            return $response;
        });
        static::assertSame($response, $middlewareResponse);
    }
}
