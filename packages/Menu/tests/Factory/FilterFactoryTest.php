<?php

declare(strict_types=1);

namespace Menu\Test\Factory;

class FilterFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingShouldReturnExpectedInstance()
    {
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($adapterMock));
        $factory = new \Menu\Factory\FilterFactory();
        static::assertInstanceOf(\Menu\Filter\MenuFilter::class, $factory($container, \Menu\Filter\MenuFilter::class));
    }
}
