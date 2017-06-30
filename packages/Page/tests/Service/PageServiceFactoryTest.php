<?php

declare(strict_types=1);

namespace Page\Test\Service;

class PageServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPaginationShouldReturnPaginationInstance()
    {
        $select = $this->getMockBuilder(\Zend\Db\Sql\Select::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $paginator = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['getPaginationSelect', 'getAdapter'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $pageMapper->expects(static::once())
            ->method('getPaginationSelect')
            ->willReturn($select);
        $pageMapper->expects(static::once())
            ->method('getAdapter')
            ->willReturn($paginator);
        $articlePostMapper = $this->getMockBuilder(\Article\Mapper\ArticlePostsMapper::class)
            ->getMockForAbstractClass();
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue(['upload' => ['public_path' => 'test', 'non_public_path' => 'test']]));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($pageMapper));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($pageFilter));
        $factory = new \Page\Service\PageServiceFactory();
        static::assertInstanceOf(\Page\Service\PageService::class, $factory($container));
    }
}
