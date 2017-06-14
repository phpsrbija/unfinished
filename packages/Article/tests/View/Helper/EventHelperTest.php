<?php
declare(strict_types = 1);
namespace Article\Test\View\Helper;

class EventUserHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnItSelf()
    {
        $eventService = $this->getMockBuilder('Article\Service\EventService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $eventHelper = new \Article\View\Helper\EventHelper($eventService);
        static::assertInstanceOf(\Article\View\Helper\EventHelper::class, $eventHelper());
    }

    public function testAllShouldReturnArray()
    {
        $eventService = $this->getMockBuilder('Article\Service\EventService')
            ->setMethods(['fetchLatest'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $eventService->expects(static::once())
            ->method('fetchLatest')
            ->willReturn([]);
        $eventHelper = new \Article\View\Helper\EventHelper($eventService);
        static::assertSame([], $eventHelper->getLatest());
    }
}