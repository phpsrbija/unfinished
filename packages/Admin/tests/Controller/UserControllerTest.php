<?php
declare(strict_types = 1);
namespace Test\Admin\Controller;

class UserControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexMethodShouldReturnHtmlResponse()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStorage'])
            ->getMock();
        $sessionManager->expects(static::any())
            ->method('getStorage')
            ->will(static::returnValue($sessionStorage));
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'index');
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $userController($request, $response));
    }

    public function testEditMethodShouldReturnHtmlResponse()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUser'])
            ->getMock();
        $adminUserService->expects(static::once())
            ->method('getUser')
            ->willReturn(new \ArrayObject());
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'edit');
        $request = $request->withAttribute('id', 1);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $userController($request, $response));
    }

    public function testEditMethodShouldReturnHtmlResponseAndUpdateUserWithRequestData()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->setMethods(['render'])
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getUser'])
            ->getMock();
        $adminUserService->expects(static::once())
            ->method('getUser')
            ->willReturn(new \ArrayObject());
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'edit');
        $request = $request->withAttribute('id', 1);
        $request = $request->withParsedBody(['user' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $userController($request, $response));
    }

    public function testSaveMethodShouldRegisterUserAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin/users'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withParsedBody(['user' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        /**
* 
         *
 * @var \Zend\Diactoros\Response $returnedResponse 
*/
        $returnedResponse = $userController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testSaveMethodShouldUpdateUserAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin/users'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['user' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        /**
* 
         *
 * @var \Zend\Diactoros\Response $returnedResponse 
*/
        $returnedResponse = $userController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testSaveMethodShouldThrowFilterExceptionAndReturnHtmlResponse()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $template->expects(static::once())
            ->method('render')
            ->will(static::returnValue('test'));
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->willThrowException(new \Core\Exception\FilterException(['test error']));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withAttribute('id', 2);
        $request = $request->withParsedBody(['user' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        /**
* 
         *
 * @var \Zend\Diactoros\Response $returnedResponse 
*/
        $returnedResponse = $userController($request, $response);
        static::assertSame(200, $returnedResponse->getStatusCode());
        static::assertInstanceOf(\Zend\Diactoros\Response\HtmlResponse::class, $returnedResponse);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage test error
     */
    public function testSaveMethodShouldThrowException()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->willThrowException(new \Exception('test error'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'save');
        $request = $request->withParsedBody(['user' => 'test']);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        $userController($request, $response);
    }

    public function testDeleteMethodShouldSucceedAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin/users'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'delete');
        $request = $request->withAttribute('id', 2);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        /**
* 
         *
 * @var \Zend\Diactoros\Response $returnedResponse 
*/
        $returnedResponse = $userController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }

    public function testDeleteMethodShouldFailAndReturnRedirect()
    {
        $user = new \stdClass();
        $user->admin_user_id = 1;
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage();
        $sessionStorage->user = $user;
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->setMethods(['delete'])
            ->disableOriginalConstructor()
            ->getMock();
        $adminUserService->expects(static::once())
            ->method('delete')
            ->willThrowException(new \Exception('test error'));
        $sessionManager = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $router->expects(static::at(0))
            ->method('generateUri')
            ->will(static::returnValue('http://unfinished.dev/admin/users'));
        $request = new \Zend\Diactoros\ServerRequest();
        $request = $request->withAttribute('action', 'delete');
        $request = $request->withAttribute('id', 2);
        $response = new \Zend\Diactoros\Response();
        $userController = new \Admin\Controller\UserController(
            $template,
            $router,
            $adminUserService,
            $sessionManager
        );
        /**
* 
         *
 * @var \Zend\Diactoros\Response $returnedResponse 
*/
        $returnedResponse = $userController($request, $response);
        static::assertSame(302, $returnedResponse->getStatusCode());
    }
}
