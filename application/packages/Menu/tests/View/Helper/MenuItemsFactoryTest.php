<?php

declare(strict_types=1);

namespace Menu\Test\View\Helper;

class MenuItemsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingMenuItemsFactoryShouldReturnExpectedInstance()
    {
        $menuService = $this->getMockBuilder(\Menu\Service\MenuService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($menuService));
        $factory = new \Menu\View\Helper\MenuItemsFactory();
        static::assertInstanceOf(\Menu\View\Helper\MenuItems::class, $factory($container, 'test'));
    }
}
