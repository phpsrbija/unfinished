<?php
declare(strict_types = 1);
namespace Test\Core\Mapper;

class AdminUsersMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testAdminUsersGetByEmailShouldReturnData()
    {
        $adminUsersMapper = new AdminUsersMapperGetByEmailMock();
        // email & password
        static::assertCount(2, $adminUsersMapper->getByEmail('admin@example.org'));
    }

    public function testAdminUsersUpdateLoginShouldReturnNumberOfAffectedRows()
    {
        $adminUsersMapper = new AdminUsersMapperUpdateLoginMock();
        static::assertSame(1, $adminUsersMapper->updateLogin('admin_user_uuid'));
    }

    public function testAdapterSetterShouldWorkAsExpectedOnAdminUsersMapper()
    {
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $adminUsersMapper = new \Core\Mapper\AdminUsersMapper();
        $adminUsersMapper->setDbAdapter($adapter);
        static::assertSame($adapter, $adminUsersMapper->getAdapter());
    }
}

class AdminUsersMapperGetByEmailMock extends \Core\Mapper\AdminUsersMapper
{
    public function select($where = null)
    {
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $data = [
            [
               'email' => 'admin@example.org',
               'password' => 'secret',
            ],
        ];
        $resultSet->initialize($data);
        return $resultSet;
    }
}

class AdminUsersMapperUpdateLoginMock extends \Core\Mapper\AdminUsersMapper
{
    public function update($set, $where = null, array $joins = null)
    {
        return 1;
    }
}
