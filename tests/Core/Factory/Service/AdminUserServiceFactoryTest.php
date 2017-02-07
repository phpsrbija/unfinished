<?php
declare(strict_types = 1);
namespace Test\Core\Factory\Service;

class TestAdminUserServiceFactory extends \PHPUnit_Framework_TestCase
{
    public function testAdminUserServiceFactoryShouldCreateInstanceOfAdminUserService()
    {
        $adminUserServiceFactory = new \Core\Factory\Service\AdminUserServiceFactory();
        $adminUserFilter = $this->getMockBuilder(\Core\Filter\AdminUserFilter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue(new \Core\Mapper\AdminUsersMapper()));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($adminUserFilter));
        static::assertInstanceOf('Core\Service\AdminUserService', $adminUserServiceFactory($container));
    }
}
