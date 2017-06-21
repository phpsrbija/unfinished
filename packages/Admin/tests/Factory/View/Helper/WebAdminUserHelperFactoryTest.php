<?php
declare(strict_types = 1);
namespace Admin\Test\Factory\View\Helper;

class WebAdminUserHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingWebUserHelperShouldReturnWebAdminUserHelper()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($adminUserService));
        $webUserHelperFactory = new \Admin\Factory\View\Helper\WebAdminUserHelperFactory();
        static::assertInstanceOf(\Admin\View\Helper\WebAdminUserHelper::class, $webUserHelperFactory($container, 'test'));
    }
}
