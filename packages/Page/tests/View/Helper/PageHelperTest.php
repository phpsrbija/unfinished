<?php
declare(strict_types = 1);
namespace Page\Test\View\Helper;

class PageHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingPageHelperShouldReturnItSelf()
    {
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $pageHelper = new \Page\View\Helper\PageHelper($pageService);
        static::assertInstanceOf(\Page\View\Helper\PageHelper::class, $pageHelper());
    }

    public function testForSelectShouldReturnArray()
    {
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->setMethods(['getForSelect'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $pageService->expects(static::once())
            ->method('getForSelect')
            ->willReturn([]);
        $pageHelper = new \Page\View\Helper\PageHelper($pageService);
        static::assertSame([], $pageHelper->forSelect());
    }
}
