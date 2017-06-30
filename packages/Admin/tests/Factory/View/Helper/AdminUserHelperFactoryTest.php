<?php

declare(strict_types=1);

namespace Admin\Test\Factory\View\Helper;

class AdminUserHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnAdminUserService()
    {
        $session = new \Zend\Session\SessionManager();
        $adminUserService = $this->getMockBuilder(\Admin\Service\AdminUserService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($session));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($adminUserService));
        $adminUserHelperFactory = new \Admin\Factory\View\Helper\AdminUserHelperFactory();
        static::assertInstanceOf(\Admin\View\Helper\AdminUserHelper::class, $adminUserHelperFactory($container, 'test'));
    }
}
