<?php
declare(strict_types = 1);
namespace Menu\Test\Mapper;

class MenuMapperTest extends \PHPUnit_Framework_TestCase
{
//    public function testSelectAllSelectShouldReturnSelectInstance()
//    {
//        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
//            ->disableOriginalConstructor()
//            ->getMockForAbstractClass();
//        $resultSetMock = $this->getMockBuilder(\Zend\Db\ResultSet\HydratingResultSet::class)
//            ->getMockForAbstractClass();
//        $menuMapper = new \Menu\Mapper\MenuMapper($adapterMock, $resultSetMock);
//        $menuMapper->setDbAdapter($adapterMock);
//        static::assertInstanceOf(\Zend\Db\Sql\Select::class, $menuMapper->selectAll());
//    }

    public function testSelectAllWithHeaderFilterShouldReturnSelectInstance()
    {
        // mock the adapter, driver, and required parts
        $resultMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\ResultInterface::class)
            ->getMockForAbstractClass();
        $statementMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\StatementInterface::class)
            ->getMockForAbstractClass();
        $statementMock->expects(static::once())
            ->method('execute')
            ->willReturn($resultMock);
        $driverMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\DriverInterface::class)
            ->getMockForAbstractClass();
        $driverMock->expects(static::once())
            ->method('createStatement')
            ->willReturn($statementMock);
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->setConstructorArgs([$driverMock])
            ->getMockForAbstractClass();

        $menuMapper = new \Menu\Mapper\MenuMapper();
        $menuMapper->setDbAdapter($adapterMock);
        $menuMapper->initialize();
        static::assertInstanceOf(\Zend\Db\ResultSet\ResultSet::class, $menuMapper->selectAll(true, ['is_in_header' => 1]));
    }

    public function testSelectAllWithFooterFilterShouldReturnSelectInstance()
    {
        // mock the adapter, driver, and required parts
        $resultMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\ResultInterface::class)
            ->getMockForAbstractClass();
        $statementMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\StatementInterface::class)
            ->getMockForAbstractClass();
        $statementMock->expects(static::once())
            ->method('execute')
            ->willReturn($resultMock);
        $driverMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\DriverInterface::class)
            ->getMockForAbstractClass();
        $driverMock->expects(static::once())
            ->method('createStatement')
            ->willReturn($statementMock);
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->setConstructorArgs([$driverMock])
            ->getMockForAbstractClass();

        $menuMapper = new \Menu\Mapper\MenuMapper();
        $menuMapper->setDbAdapter($adapterMock);
        $menuMapper->initialize();
        static::assertInstanceOf(\Zend\Db\ResultSet\ResultSet::class, $menuMapper->selectAll(true, ['is_in_footer' => 1]));
    }

    public function testSelectAllWithSideFilterShouldReturnSelectInstance()
    {
        // mock the adapter, driver, and required parts
        $resultMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\ResultInterface::class)
            ->getMockForAbstractClass();
        $statementMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\StatementInterface::class)
            ->getMockForAbstractClass();
        $statementMock->expects(static::once())
            ->method('execute')
            ->willReturn($resultMock);
        $driverMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\DriverInterface::class)
            ->getMockForAbstractClass();
        $driverMock->expects(static::once())
            ->method('createStatement')
            ->willReturn($statementMock);
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->setConstructorArgs([$driverMock])
            ->getMockForAbstractClass();

        $menuMapper = new \Menu\Mapper\MenuMapper();
        $menuMapper->setDbAdapter($adapterMock);
        $menuMapper->initialize();
        static::assertInstanceOf(\Zend\Db\ResultSet\ResultSet::class, $menuMapper->selectAll(true, ['is_in_side' => 1]));
    }

    public function testInsertmenuItemShouldReturnId()
    {
        // mock the adapter, driver, and required parts
        $resultMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\ResultInterface::class)
            ->getMockForAbstractClass();
        $statementMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\StatementInterface::class)
            ->getMockForAbstractClass();
        $statementMock->expects(static::once())
            ->method('execute')
            ->willReturn($resultMock);
        $driverMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\DriverInterface::class)
            ->getMockForAbstractClass();
        $driverMock->expects(static::once())
            ->method('createStatement')
            ->willReturn($statementMock);
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->setConstructorArgs([$driverMock])
            ->getMockForAbstractClass();

        $menuMapper = new \Menu\Mapper\MenuMapper();
        $menuMapper->setDbAdapter($adapterMock);
        $menuMapper->initialize();
        static::assertInstanceOf(\Zend\Db\ResultSet\ResultSet::class, $menuMapper->insertMenuItem([]));
    }
}