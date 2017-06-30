<?php

declare(strict_types=1);

namespace Article\Test\View\Helper;

class VideoHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnItSelf()
    {
        $videoService = $this->getMockBuilder('Article\Service\VideoService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $videoHelper = new \Article\View\Helper\VideoHelper($videoService);
        static::assertInstanceOf(\Article\View\Helper\VideoHelper::class, $videoHelper());
    }

    public function testGetLatestShouldReturnArray()
    {
        $videoService = $this->getMockBuilder('Article\Service\VideoService')
            ->setMethods(['fetchLatest'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $videoService->expects(static::once())
            ->method('fetchLatest')
            ->willReturn([]);
        $videoHelper = new \Article\View\Helper\VideoHelper($videoService);
        static::assertSame([], $videoHelper->getLatest());
    }
}
