<?php
declare(strict_types = 1);
namespace Test\Article\Controller;

class DiscussionServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokingFactoryShouldReturnExpectedInstance()
    {
        $articleMapper = $this->getMockBuilder(\Article\Mapper\ArticleMapper::class)
            ->getMockForAbstractClass();
        $articleDiscussionMapper = $this->getMockBuilder(\Article\Mapper\ArticleDiscussionsMapper::class)
            ->getMockForAbstractClass();
        $articleFilter = $this->getMockBuilder(\Article\Filter\ArticleFilter::class)
            ->getMockForAbstractClass();
        $discussionFilter = $this->getMockBuilder(\Article\Filter\DiscussionFilter::class)
            ->getMockForAbstractClass();
        $categoryMapper = $this->getMockBuilder(\Category\Mapper\CategoryMapper::class)
            ->getMockForAbstractClass();
        $adminUsersMapper = $this->getMockBuilder(\Core\Mapper\AdminUsersMapper::class)
            ->getMockForAbstractClass();

        $container = $this->getMockBuilder(\Interop\Container\ContainerInterface::class)
            ->setMethods(['get'])
            ->getMockForAbstractClass();
        $container->expects(static::at(0))
            ->method('get')
            ->will(static::returnValue($articleMapper));
        $container->expects(static::at(1))
            ->method('get')
            ->will(static::returnValue($articleDiscussionMapper));
        $container->expects(static::at(2))
            ->method('get')
            ->will(static::returnValue($articleFilter));
        $container->expects(static::at(3))
            ->method('get')
            ->will(static::returnValue($discussionFilter));
        $container->expects(static::at(4))
            ->method('get')
            ->will(static::returnValue($categoryMapper));
        $container->expects(static::at(5))
            ->method('get')
            ->will(static::returnValue($adminUsersMapper));
        $factory = new \Article\Factory\Service\DiscussionServiceFactory();
        static::assertInstanceOf(\Article\Service\DiscussionService::class, $factory($container));
    }
}