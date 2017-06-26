<?php
declare(strict_types = 1);
namespace Newsletter\Test\Mapper;

class NewsletterMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Set Adapter in constructor.
     */
    public function testSetDbAdapterShouldThrowException()
    {
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $resultSetMock = $this->getMockBuilder(\Zend\Db\ResultSet\HydratingResultSet::class)
            ->getMockForAbstractClass();
        $newsletterMapper = new \Newsletter\Mapper\NewsletterMapper($adapterMock, $resultSetMock);
        $newsletterMapper->setDbAdapter($adapterMock);
    }
}