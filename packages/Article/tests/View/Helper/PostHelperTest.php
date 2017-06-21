<?php
declare(strict_types = 1);
namespace Article\Test\View\Helper;

class PostUserHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnItSelf()
    {
        $postService = $this->getMockBuilder('Article\Service\PostService')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $postHelper = new \Article\View\Helper\PostHelper($postService);
        static::assertInstanceOf(\Article\View\Helper\PostHelper::class, $postHelper());
    }

    public function testForSelectShouldReturnArray()
    {
        $postService = $this->getMockBuilder('Article\Service\PostService')
            ->setMethods(['getForSelect'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $postService->expects(static::once())
            ->method('getForSelect')
            ->willReturn([]);
        $postHelper = new \Article\View\Helper\PostHelper($postService);
        static::assertSame([], $postHelper->forSelect());
    }

    public function testForWebShouldReturnArray()
    {
        $postService = $this->getMockBuilder('Article\Service\PostService')
            ->setMethods(['getLatestWeb'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $postService->expects(static::once())
            ->method('getLatestWeb')
            ->willReturn([]);
        $postHelper = new \Article\View\Helper\PostHelper($postService);
        static::assertSame([], $postHelper->forWeb());
    }
}
