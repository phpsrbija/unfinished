<?php
declare(strict_types = 1);
namespace Category\Test\View\Helper;

class CategoryHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingAdminUserHelperShouldReturnItSelf()
    {
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $categoryHelper = new \Category\View\Helper\CategoryHelper($categoryService);
        static::assertInstanceOf(\Category\View\Helper\CategoryHelper::class, $categoryHelper());
    }

    public function testForSelectShouldReturnArray()
    {
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->setMethods(['getAll'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $categoryService->expects(static::once())
            ->method('getAll')
            ->willReturn([]);
        $categoryHelper = new \Category\View\Helper\CategoryHelper($categoryService);
        static::assertSame([], $categoryHelper->forSelect());
    }

    public function testForHomepageShouldReturnArray()
    {
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->setMethods(['getCategoriesWithPosts'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $categoryService->expects(static::once())
            ->method('getCategoriesWithPosts')
            ->willReturn([]);
        $categoryHelper = new \Category\View\Helper\CategoryHelper($categoryService);
        static::assertSame([], $categoryHelper->forHomepage());
    }
}
