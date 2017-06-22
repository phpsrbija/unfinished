<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testUserFactoryShouldCreateExpectedUserControllerInstance()
    {
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService.old')
            ->disableOriginalConstructor()
            ->setMethods(['loginUser'])
            ->getMockForAbstractClass();
        $session = new \Zend\Session\SessionManager();
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
        $factory = new \Admin\Factory\Controller\UserFactory();
        static::assertInstanceOf(\Admin\Controller\UserController::class, $factory($container));
    }
}
