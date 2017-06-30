<?php
declare(strict_types = 1);
namespace Admin\Test\Service;

class AdminUserServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testUserLoginShouldReturnUserDataIfUserIsProperlyLoggedIn()
    {
        $userData = new class {
            public $email = 'admin@example.org';
            public $password = 'secret';
            public $admin_user_uuid = 'uuid';
            public $admin_user_id = '123';
        };
        $bcrypt = $this->getMockBuilder(\Zend\Crypt\Password\Bcrypt::class)
            ->setMethods(['verify'])
            ->getMock();
        $bcrypt->expects(static::once())
            ->method('verify')
            ->will(static::returnValue(true));
        $adminUsersMapper = $this->getMockBuilder(\Admin\Mapper\AdminUsersMapper::class)
            ->setMethods(['getByEmail', 'updateLogin'])
            ->getMock();
        $adminUsersMapper->expects(static::once())
            ->method('updateLogin')
            ->will(static::returnValue(1));
        $adminUsersMapper->expects(static::once())
            ->method('getByEmail')
            ->will(static::returnValue($userData));
        $adminUsersFilter = $this->getMockBuilder(\Admin\Filter\AdminUserFilter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserService = new \Admin\Service\AdminUserService($bcrypt, $adminUsersMapper, $adminUsersFilter, $upload);
        static::assertSame($userData, $adminUserService->loginUser('admin@example.org', 'secret'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Password does not match.
     */
    public function testUserLoginShouldThrowExceptionIfCredentialsVerificationFails()
    {
        $userData = new class {
            public $email = 'admin@example.org';
            public $password = 'secret';
            public $admin_user_uuid = 'uuid';
        };
        $bcrypt = $this->getMockBuilder(\Zend\Crypt\Password\Bcrypt::class)
            ->setMethods(['verify'])
            ->getMock();
        $bcrypt->expects(static::once())
            ->method('verify')
            ->will(static::returnValue(false));
        $adminUsersMapper = $this->getMockBuilder(\Admin\Mapper\AdminUsersMapper::class)
            ->setMethods(['getByEmail'])
            ->getMock();
        $adminUsersMapper->expects(static::once())
            ->method('getByEmail')
            ->will(static::returnValue($userData));
        $adminUsersFilter = $this->getMockBuilder(\Admin\Filter\AdminUserFilter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserService = new \Admin\Service\AdminUserService($bcrypt, $adminUsersMapper, $adminUsersFilter, $upload);
        $adminUserService->loginUser('admin@example.org', 'secret');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage User does not exist.
     */
    public function testUserLoginShouldThrowExceptionIfUserEmailDoesNotExist()
    {
        $userData = null;
        $bcrypt = $this->getMockBuilder(\Zend\Crypt\Password\Bcrypt::class)
            ->getMock();
        $adminUsersMapper = $this->getMockBuilder(\Admin\Mapper\AdminUsersMapper::class)
            ->setMethods(['getByEmail'])
            ->getMock();
        $adminUsersMapper->expects(static::once())
            ->method('getByEmail')
            ->will(static::returnValue($userData));
        $adminUsersFilter = $this->getMockBuilder(\Admin\Filter\AdminUserFilter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserService = new \Admin\Service\AdminUserService($bcrypt, $adminUsersMapper, $adminUsersFilter, $upload);
        $adminUserService->loginUser('admin@example.org', 'secret');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Both email and password are required.
     */
    public function testUserLoginShouldThrowExceptionIfUserEmailAreNotPassed()
    {
        $userData = null;
        $bcrypt = $this->getMockBuilder(\Zend\Crypt\Password\Bcrypt::class)
            ->getMock();
        $adminUsersMapper = $this->getMockBuilder(\Admin\Mapper\AdminUsersMapper::class)
            ->getMock();
        $adminUsersFilter = $this->getMockBuilder(\Admin\Filter\AdminUserFilter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserService = new \Admin\Service\AdminUserService($bcrypt, $adminUsersMapper, $adminUsersFilter, $upload);
        $adminUserService->loginUser(false, false);
    }
}
