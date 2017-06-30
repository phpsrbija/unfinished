<?php

declare(strict_types=1);

namespace Menu\Test\View\Helper;

class MenuItemsTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingMenuItemsHelperShouldReturnItSelf()
    {
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuHelper = new \Menu\View\Helper\MenuItems($menuService);
        static::assertInstanceOf(\Menu\View\Helper\MenuItems::class, $menuHelper());
    }

    public function testForMenuShouldReturnArray()
    {
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->setMethods(['getNestedAll'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuService->expects(static::once())
            ->method('getNestedAll')
            ->willReturn([]);
        $menuHelper = new \Menu\View\Helper\MenuItems($menuService);
        static::assertSame([], $menuHelper->forMenu());
    }

    public function testGetHeaderMenuShouldReturnArray()
    {
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->setMethods(['getNestedAll'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuService->expects(static::once())
            ->method('getNestedAll')
            ->willReturn([]);
        $menuHelper = new \Menu\View\Helper\MenuItems($menuService);
        static::assertSame([], $menuHelper->getHeaderMenu());
    }

    public function testGetFooterShouldReturnArray()
    {
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->setMethods(['getNestedAll'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuService->expects(static::once())
            ->method('getNestedAll')
            ->willReturn([]);
        $menuHelper = new \Menu\View\Helper\MenuItems($menuService);
        static::assertSame([], $menuHelper->getFooterMenu());
    }

    public function testGetSideMenuShouldReturnArray()
    {
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->setMethods(['getNestedAll'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuService->expects(static::once())
            ->method('getNestedAll')
            ->willReturn([]);
        $menuHelper = new \Menu\View\Helper\MenuItems($menuService);
        static::assertSame([], $menuHelper->getSideMenu());
    }
}
