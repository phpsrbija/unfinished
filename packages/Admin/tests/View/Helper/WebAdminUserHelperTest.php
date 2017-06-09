<?php
declare(strict_types = 1);
namespace Admin\Test\View\Helper;

class WebAdminUserHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnItSelf()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserHelper = new \Admin\View\Helper\WebAdminUserHelper($adminUserService);
        static::assertInstanceOf(\Admin\View\Helper\WebAdminUserHelper::class, $adminUserHelper());
    }

    public function testGetRandomShouldReturnArray()
    {
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->setMethods(['getForWeb'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserService->expects(static::once())
            ->method('getForWeb')
            ->willReturn([]);
        $adminUserHelper = new \Admin\View\Helper\WebAdminUserHelper($adminUserService);
        static::assertSame([], $adminUserHelper->getRandom());
    }
}