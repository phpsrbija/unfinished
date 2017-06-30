<?php

declare(strict_types=1);

namespace Page\Test\Mapper;

class PageMapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnExpectedInstance()
    {
        $adapterMapper = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($adapterMapper));
        $factory = new \Page\Mapper\PageMapperFactory();
        static::assertInstanceOf(\Page\Mapper\PageMapper::class, $factory($container));
    }
}
