<?php
declare(strict_types = 1);
namespace Page\Test\Mapper;

class PageMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPaginationSelectShouldReturnSelectInstance()
    {
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $resultSetMock = $this->getMockBuilder(\Zend\Db\ResultSet\HydratingResultSet::class)
            ->getMockForAbstractClass();
        $pageMapper = new \Page\Mapper\PageMapper($adapterMock, $resultSetMock);
        static::assertInstanceOf(\Zend\Db\Sql\Select::class, $pageMapper->getPaginationSelect());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Set DB adapter in constructor.
     */
    public function testSetDbAdapterShouldThrowException()
    {
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $resultSetMock = $this->getMockBuilder(\Zend\Db\ResultSet\HydratingResultSet::class)
            ->getMockForAbstractClass();
        $pageMapper = new \Page\Mapper\PageMapper($adapterMock, $resultSetMock);
        $pageMapper->setDbAdapter($adapterMock);
    }

    public function testGetActivePageShouldReturnResultSet()
    {
        // mock the adapter, driver, and required parts
        $resultMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\ResultInterface::class)
            ->getMockForAbstractClass();
        $statementMock = $this->getMockBuilder(\Zend\Db\Adapter\Driver\StatementInterface::class)
            ->getMockForAbstractClass();
        $statementMock->expects(static::once())
            ->method('execute')
            ->willReturn($resultMock);
        $driverMock = $this->getMockBuilder('Zend\Db\Adapter\Driver\DriverInterface')
            ->getMockForAbstractClass();
        $driverMock->expects(static::once())
            ->method('createStatement')
            ->willReturn($statementMock);
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->setConstructorArgs([$driverMock])
            ->getMockForAbstractClass();
        $resultSetMock = $this->getMockBuilder(\Zend\Db\ResultSet\HydratingResultSet::class)
            ->getMockForAbstractClass();

        $pageMapper = new \Page\Mapper\PageMapper($adapterMock, $resultSetMock);
        $pageMapper->initialize();
        static::assertInstanceOf(\Zend\Db\ResultSet\HydratingResultSet::class, $pageMapper->getActivePage('test'));
    }
}