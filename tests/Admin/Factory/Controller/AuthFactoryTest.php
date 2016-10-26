<?php
declare(strict_types = 1);
namespace Test\Admin\Factory\Controller;

class AuthFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthControllerFactoryShouldCreateExpectedControllerInstance()
    {
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder('Zend\Expressive\Template\TemplateRendererInterface')
            ->getMockForAbstractClass();
        $session = new \Zend\Session\SessionManager();
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($router));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($template));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($session));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($adminUserService));
        $authFactory = new \Admin\Factory\Controller\AuthFactory();
        static::assertInstanceOf('Admin\Controller\AuthController', $authFactory($container));
    }
}