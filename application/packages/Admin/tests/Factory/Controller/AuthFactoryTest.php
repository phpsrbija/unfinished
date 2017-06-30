<?php

declare(strict_types=1);

namespace Admin\Test\Factory\Controller;

class AuthFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthControllerFactoryShouldCreateExpectedControllerInstance()
    {
        $router = $this->getMockBuilder(\Zend\Expressive\Router\RouterInterface::class)
            ->getMockForAbstractClass();
        $template = $this->getMockBuilder(\Zend\Expressive\Template\TemplateRendererInterface::class)
            ->getMockForAbstractClass();
        $session = new \Zend\Session\SessionManager();
        $adminUserService = $this->getMockBuilder(\Admin\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
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
