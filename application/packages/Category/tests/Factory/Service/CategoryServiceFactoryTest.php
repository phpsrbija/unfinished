<?php

declare(strict_types=1);

namespace Category\Test\Factory\Service;

class CategoryServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $categoryFilter = $this->getMockBuilder(\Category\Filter\CategoryFilter::class)
            ->getMockForAbstractClass();
        $categoryMapper = $this->getMockBuilder(\Category\Mapper\CategoryMapper::class)
            ->getMockForAbstractClass();
        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue(['upload' => ['public_path' => 'test', 'non_public_path' => 'test']]));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($categoryMapper));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($categoryFilter));
        $factory = new \Category\Factory\Service\CategoryServiceFactory();
        static::assertInstanceOf(\Category\Service\CategoryService::class, $factory($container));
    }
}
