<?php

declare(strict_types=1);

namespace Menu\Test\View\Helper;

class MenuUrlHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingUrlHelperWithHrefShouldReturnString()
    {
        $urlHelper = $this->getMockBuilder(\Zend\Expressive\Helper\UrlHelper::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuHelper = new \Menu\View\Helper\MenuUrlHelper($urlHelper);
        static::assertSame('http://test.example.com', $menuHelper(['href' => 'http://test.example.com']));
    }

    public function testInvokingUrlHelperWithPageSlugShouldReturnString()
    {
        $urlHelper = $this->getMockBuilder(\Zend\Expressive\Helper\UrlHelper::class)
            ->setMethods(['__invoke'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $urlHelper->expects(static::once())
            ->method('__invoke')
            ->willReturn('test');
        $menuHelper = new \Menu\View\Helper\MenuUrlHelper($urlHelper);
        static::assertSame('test', $menuHelper(['page_slug' => 'test-slug', 'href' => false]));
    }

    public function testInvokingUrlHelperWithCategorySlugShouldReturnString()
    {
        $urlHelper = $this->getMockBuilder(\Zend\Expressive\Helper\UrlHelper::class)
            ->setMethods(['__invoke'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $urlHelper->expects(static::once())
            ->method('__invoke')
            ->willReturn('test');
        $menuHelper = new \Menu\View\Helper\MenuUrlHelper($urlHelper);
        static::assertSame('test', $menuHelper(['category_slug' => 'test-slug', 'href' => false, 'page_slug' => false]));
    }

    public function testInvokingUrlHelperWithAllParamsFalseShouldReturnString()
    {
        $urlHelper = $this->getMockBuilder(\Zend\Expressive\Helper\UrlHelper::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuHelper = new \Menu\View\Helper\MenuUrlHelper($urlHelper);
        static::assertSame('#', $menuHelper(['category_slug' => false, 'href' => false, 'page_slug' => false]));
    }
}
