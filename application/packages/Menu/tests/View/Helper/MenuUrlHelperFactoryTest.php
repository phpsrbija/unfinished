<?php

declare(strict_types=1);

namespace Menu\Test\View\Helper;

class MenuUrlHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingMenuItemsFactoryShouldReturnExpectedInstance()
    {
        $urlHelper = $this->getMockBuilder(\Zend\Expressive\Helper\UrlHelper::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($urlHelper));
        $factory = new \Menu\View\Helper\MenuUrlHelperFactory();
        static::assertInstanceOf(\Menu\View\Helper\MenuUrlHelper::class, $factory($container, 'test'));
    }
}
