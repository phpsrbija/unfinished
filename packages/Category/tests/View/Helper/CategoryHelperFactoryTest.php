<?php
declare(strict_types = 1);
namespace Category\Test\View\Helper;

class CategoryHelperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($categoryService));
        $factory = new \Category\View\Helper\CategoryHelperFactory();
        static::assertInstanceOf(\Category\View\Helper\CategoryHelper::class, $factory($container, 'test'));
    }
}
