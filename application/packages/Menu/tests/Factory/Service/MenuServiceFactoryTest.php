<?php

declare(strict_types=1);

namespace Menu\Test\Factory\Service;

class MenuServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingShouldReturnExpectedInstance()
    {
        $menuMapperMock = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuFilterMock = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $categoryServiceMock = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $pageServiceMock = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($menuMapperMock));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($menuFilterMock));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($categoryServiceMock));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($pageServiceMock));
        $factory = new \Menu\Factory\Service\MenuServiceFactory();
        static::assertInstanceOf(\Menu\Service\MenuService::class, $factory($container, 'test'));
    }
}
