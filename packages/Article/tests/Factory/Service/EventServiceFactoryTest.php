<?php
declare(strict_types = 1);
namespace Test\Article\Controller;

class EventServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $articleMapper = $this->getMockBuilder(\Article\Mapper\ArticleMapper::class)
            ->getMockForAbstractClass();
        $articleEventMapper = $this->getMockBuilder(\Article\Mapper\ArticleEventsMapper::class)
            ->getMockForAbstractClass();
        $articleFilter = $this->getMockBuilder(\Article\Filter\ArticleFilter::class)
            ->getMockForAbstractClass();
        $eventFilter = $this->getMockBuilder(\Article\Filter\EventFilter::class)
            ->getMockForAbstractClass();
        $categoryMapper = $this->getMockBuilder(\Category\Mapper\CategoryMapper::class)
            ->getMockForAbstractClass();
        $adminUsersMapper = $this->getMockBuilder(\Admin\Mapper\AdminUsersMapper::class)
            ->getMockForAbstractClass();

        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue(['upload' => ['public_path' => 'test', 'non_public_path' => 'test']]));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($articleMapper));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($articleEventMapper));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($articleFilter));
        $container->expects(static::at(4))
            ->method('get')
            ->will(static::returnValue($eventFilter));
        $container->expects(static::at(5))
            ->method('get')
            ->will(static::returnValue($categoryMapper));
        $container->expects(static::at(6))
            ->method('get')
            ->will(static::returnValue($adminUsersMapper));
        $factory = new \Article\Factory\Service\EventServiceFactory();
        static::assertInstanceOf(\Article\Service\EventService::class, $factory($container));
    }
}