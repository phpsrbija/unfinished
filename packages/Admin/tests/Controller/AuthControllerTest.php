<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

class AuthControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIfUserAlreadyLoggedInRedirectShouldBePerformed()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'login');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->setMethods(['generateUri'])
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $sessionManager = $this->getMockBuilder('Zend\Session\SessionManager')
            ->setMethods(['getStorage', 'writeClose'])
            ->getMock();
        $sessionManager->expects(static::at(0))
            ->method('getStorage')
            ->will(static::returnValue(
                new class {
                    public $user = true;
                }
            ));
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\EmptyResponse $response */
        $response = $auth($request, $response);
        static::assertSame(302, $response->getStatusCode());
        static::assertSame(['http://unfinished.dev/admin'], $response->getHeader('Location'));
    }

    public function testIfUserNotLoggedInLoginActionShouldTakeHimToLoginHtmlPage()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::at(0))
            ->method('render')
            ->will(static::returnValue('test'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'login');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $sessionManager = $this->getMockBuilder('Zend\Session\SessionManager')
            ->setMethods(['getStorage', 'writeClose'])
            ->getMock();
        $sessionManager->expects(static::at(0))
            ->method('getStorage')
            ->will(static::returnValue(
                new class {
                    public $user = false;
                }
            ));
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\HtmlResponse $response */
        $response = $auth($request, $response);
        static::assertSame(200, $response->getStatusCode());
        static::assertSame('test', $response->getBody()->getContents());
    }

    public function testUserLogoutShouldClearSessionStorage()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'logout');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->setMethods(['generateUri'])
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage([
            'user' => 'user@example.org',
        ]);
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\HtmlResponse $response */
        $response = $auth($request, $response);
        static::assertNull($sessionManager->getStorage()->user);
        static::assertSame(302, $response->getStatusCode());
        static::assertSame(['http://unfinished.dev/admin'], $response->getHeader('Location'));
    }

    public function testUserLoginHandleWithCorrectCredentialsShouldSetUserInSessionStorage()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->setMethods(['loginUser'])
            ->getMockForAbstractClass();
        $adminUserService->expects(static::once())
            ->method('loginUser')
            ->will(static::returnValue(
                new class {
                    public $isLoggedIn = true;
                }
            ));
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withParsedBody([
            'email' => 'admin@example.org',
            'password' => 'secret',
        ]);
        $request = $request->withAttribute('action', 'loginHandle');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->setMethods(['generateUri'])
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\HtmlResponse $response */
        $response = $auth($request, $response);
        static::assertTrue($sessionManager->getStorage()->user->isLoggedIn);
        static::assertSame(302, $response->getStatusCode());
        static::assertSame(['http://unfinished.dev/admin'], $response->getHeader('Location'));
    }

    public function testUserLoginHandleWithWrongCredentialsShouldNotSetUserInSessionStorage()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->setMethods(['loginUser'])
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withParsedBody([
            'email' => 'admin@test',
            'password' => 'secretpass',
        ]);
        $request = $request->withAttribute('action', 'loginHandle');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->setMethods(['generateUri'])
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $sessionManager->getStorage()->user = null;
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\HtmlResponse $response */
        $response = $auth($request, $response);
        static::assertNull($sessionManager->getStorage()->user);
        static::assertSame(302, $response->getStatusCode());
        static::assertSame(['http://unfinished.dev/admin'], $response->getHeader('Location'));
    }

    public function testUserLoginHandleWitAlreadyLoggedInUserShouldRedirectToAdminPage()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'loginHandle');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->setMethods(['generateUri'])
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin'));
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage([
            'user' => true,
        ]);
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\HtmlResponse $response */
        $response = $auth($request, $response);
        static::assertSame(302, $response->getStatusCode());
        static::assertSame(['http://unfinished.dev/admin'], $response->getHeader('Location'));
    }

    public function testUserLoginHandleShouldThrowExceptionAndDisplayMessage()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->setMethods(['loginUser'])
            ->getMockForAbstractClass();
        $adminUserService->expects(static::once())
            ->method('loginUser')
            ->willThrowException(new \Exception('test error'));
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnCallback(
                function($tpl, $error) {
                    return $error['error'];
                }
            ));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withParsedBody([
            'email' => 'admin@test',
            'password' => 'secretpass',
        ]);
        $request = $request->withAttribute('action', 'loginHandle');
        $response = new \Zend\Diactoros\Response\EmptyResponse();
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->setStorage($sessionStorage);
        $sessionManager->getStorage()->user = null;
        $auth = new \Admin\Controller\AuthController($router, $template, $sessionManager, $adminUserService);
        /** @var \Zend\Diactoros\Response\HtmlResponse $response */
        $response = $auth($request, $response);
        static::assertNull($sessionManager->getStorage()->user);
        static::assertSame(200, $response->getStatusCode());
        static::assertSame('test error', $response->getBody()->getContents());
    }
}
