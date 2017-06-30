<?php

declare(strict_types=1);

namespace Test\Page\View\Helper;

class PageHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($pageService));
        $factory = new \Page\View\Helper\PageHelperFactory();
        static::assertInstanceOf(\Page\View\Helper\PageHelper::class, $factory($container, 'test'));
    }
}
