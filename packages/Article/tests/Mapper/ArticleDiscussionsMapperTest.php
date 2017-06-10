<?php
declare(strict_types = 1);
namespace Test\Article\Mapper;

class ArticleDiscussionsMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPaginationSelectShouldReturnSelectObject()
    {
        $adapterMock = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $articleDiscussionMapper = new \Article\Mapper\ArticleDiscussionsMapper();
        $articleDiscussionMapper->setDbAdapter($adapterMock);
        $articleDiscussionMapper->initialize();
        static::assertInstanceOf(\Zend\Db\Sql\Select::class, $articleDiscussionMapper->getPaginationSelect());
    }

//    public function testGetShouldReturnSelectArray()
//    {
//        $driverMock = $this->getMockBuilder('Zend\Db\Adapter\Driver\DriverInterface')
//            ->getMockForAbstractClass();
//        $adapter = new \Zend\Db\Adapter\Adapter($driverMock);
//        $adapterMock = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
//            ->setConstructorArgs([$driverMock])
//            ->getMockForAbstractClass();
//        $articleDiscussionMapper = new \Article\Mapper\ArticleDiscussionsMapper();
//        $articleDiscussionMapper->setDbAdapter($adapterMock);
//        $articleDiscussionMapper->initialize();
//        static::assertInternalType('array', $articleDiscussionMapper->get(1));
//    }
}
