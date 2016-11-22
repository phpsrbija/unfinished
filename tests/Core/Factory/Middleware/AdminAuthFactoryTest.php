<?php
declare(strict_types = 1);
namespace Test\Core\Factory\Middleware;

class AdminAuthFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAdminAuthFactoryTestShouldReturnInstanceOfCoreAdminAuthMiddleware()
    {
        $router = $this->getMockBuilder('Zend\Expressive\Router\RouterInterface')
            ->getMockForAbstractClass();
        $session = new \Zend\Session\SessionManager();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($router));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($session));
        $adminAuthFactory = new \Core\Factory\Middleware\AdminAuthFactory();
        static::assertInstanceOf('Core\Middleware\AdminAuth', $adminAuthFactory($container));
    }
}
