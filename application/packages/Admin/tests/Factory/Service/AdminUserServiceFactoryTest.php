<?php

declare(strict_types=1);

namespace Admin\Test\Factory\Service;

class AdminUserServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testAdminUserServiceFactoryShouldCreateInstanceOfAdminUserService()
    {
        $adminUserServiceFactory = new \Admin\Factory\Service\AdminUserServiceFactory();
        $adminUserFilter = $this->getMockBuilder(\Admin\Filter\AdminUserFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue(['upload' => ['public_path' => 'test', 'non_public_path' => 'test']]));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue(new \Admin\Mapper\AdminUsersMapper()));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($adminUserFilter));
        static::assertInstanceOf(\Admin\Service\AdminUserService::class, $adminUserServiceFactory($container));
    }
}
