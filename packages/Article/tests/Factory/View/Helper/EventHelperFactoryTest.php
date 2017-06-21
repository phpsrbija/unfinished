<?php
declare(strict_types = 1);
namespace Test\Article\View\Helper;

class EventHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $eventService = $this->getMockBuilder('Article\Service\EventService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($eventService));
        $factory = new \Article\Factory\View\Helper\EventHelperFactory();
        static::assertInstanceOf(\Article\View\Helper\EventHelper::class, $factory($container, 'test'));
    }
}
