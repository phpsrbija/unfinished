<?php
declare(strict_types = 1);
namespace Test\Core\Factory\Service;

class TestAdminUserServiceFactory extends \PHPUnit_Framework_TestCase
{
    public function testAdminUserServiceFactoryShouldCreateInstanceOfAdminUserService()
    {
        $adminUserServiceFactory = new \Core\Factory\Service\AdminUserServiceFactory();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::once())
            ->method('get')
            ->will(static::returnValue(new \Core\Mapper\AdminUsersMapper()));
        static::assertInstanceOf('Core\Service\AdminUserService', $adminUserServiceFactory($container));
    }
}
