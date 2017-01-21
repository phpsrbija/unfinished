<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testUserFactoryShouldCreateExpectedUserControllerInstance()
    {
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $session = $this->getMockBuilder(\Zend\Session\SessionManager::class)
            ->getMockForAbstractClass();
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder(\Core\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($template));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($router));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($adminUserService));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($session));
        $userFactory = new \Admin\Factory\Controller\UserFactory();
        static::assertInstanceOf(\Admin\Controller\UserController::class, $userFactory($container));
    }
}
