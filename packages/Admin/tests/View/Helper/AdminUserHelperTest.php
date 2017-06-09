<?php
declare(strict_types = 1);
namespace Admin\Test\View\Helper;

class AdminUserHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnItSelf()
    {
        $session = new \Zend\Session\SessionManager();
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserHelper = new \Admin\View\Helper\AdminUserHelper($session, $adminUserService);
        static::assertInstanceOf(\Admin\View\Helper\AdminUserHelper::class, $adminUserHelper());
    }

    public function testCurrentShouldReturnUserFromSession()
    {
        $sessionStorage = new \Zend\Session\Storage\ArrayStorage([
            'user' => true,
        ]);
        $session = new \Zend\Session\SessionManager();
        $session->setStorage($sessionStorage);
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserHelper = new \Admin\View\Helper\AdminUserHelper($session, $adminUserService);
        static::assertTrue($adminUserHelper->current());
    }

    public function testAllShouldReturnArray()
    {
        $session = new \Zend\Session\SessionManager();
        $adminUserService = $this->getMockBuilder('Core\Service\AdminUserService')
            ->setMethods(['getAll'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserService->expects(static::once())
            ->method('getAll')
            ->willReturn([]);
        $adminUserHelper = new \Admin\View\Helper\AdminUserHelper($session, $adminUserService);
        static::assertSame([], $adminUserHelper->all());
    }
}