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
}
